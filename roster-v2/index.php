<?php
// ──────────────────────────────────────────────────
// Roster V2 Prototype — Concept A: Filter-in-Place
// Reads from data/artists.json + data/roster.json
// ──────────────────────────────────────────────────

$artists_json = file_get_contents(__DIR__ . '/../data/artists.json');
$roster_json  = file_get_contents(__DIR__ . '/../data/roster.json');
$artists_data = json_decode($artists_json, true) ?: [];
$roster_data  = json_decode($roster_json, true) ?: [];

// Extract Simian URLs from existing static pages (videoLong is truncated in JSON)
function extractSimianUrls() {
    $urls = [];
    $pages = [
        __DIR__ . '/../roster/edit.php',
        __DIR__ . '/../roster/color.php',
        __DIR__ . '/../roster/sound.php',
        __DIR__ . '/../roster/vfx.php',
    ];
    foreach ($pages as $page) {
        if (!file_exists($page)) continue;
        $content = file_get_contents($page);
        preg_match_all(
            '/data-longVideo=[\'"].*?apollo\.gosimian\.com\/share\/v\/([^\/\s"\']+).*?data-videoName="([^"]+)".*?data-videoSubName="([^"]*?)"/s',
            $content, $matches, PREG_SET_ORDER
        );
        foreach ($matches as $m) {
            $key = $m[2] . '|' . $m[3];
            $urls[$key] = 'https://apollo.gosimian.com/share/v/' . $m[1] . '/false/auto/auto/ffffff/000000/';
        }
    }
    return $urls;
}

$simian_urls = extractSimianUrls();

// Build structured department -> artist -> videos tree
$dept_order = ['EDIT', 'COLOR', 'SOUND', 'VFX'];
$dept_labels = [
    'EDIT'  => 'EDIT',
    'COLOR' => 'COLOR',
    'SOUND' => 'SOUND',
    'VFX'   => 'VFX',
];

// Index artists by ID
$artists_by_id = [];
foreach ($artists_data as $artist) {
    $artists_by_id[$artist['id']] = $artist;
}

// Build departments array
$departments = [];
foreach ($dept_order as $dept) {
    $dept_artists = [];
    if (isset($roster_data[$dept])) {
        foreach ($roster_data[$dept] as $artist_id) {
            if (isset($artists_by_id[$artist_id])) {
                $artist = $artists_by_id[$artist_id];
                if (!empty($artist['visible'])) {
                    $dept_artists[] = $artist;
                }
            }
        }
    }
    usort($dept_artists, function($a, $b) {
        return ($a['order'] ?? 0) - ($b['order'] ?? 0);
    });
    $departments[$dept] = $dept_artists;
}

// Build JS data object
$js_data = [];
foreach ($departments as $dept => $artists) {
    $js_dept = [];
    foreach ($artists as $artist) {
        $js_dept[] = [
            'id'       => $artist['id'],
            'name'     => $artist['name'],
            'slug'     => $artist['slug'],
            'category' => $dept,
            'videoCount' => count($artist['videos'] ?? []),
        ];
    }
    $js_data[$dept] = $js_dept;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>roster | APOLLO</title>
    <link rel="stylesheet" href="/roster-v2/style.css?v=1.0.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="header-logo">
            <a href="/"><img src="/fonts/logo.png" alt="Apollo"></a>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="/work/">ROSTER</a></li>
                <li><a href="/contact/">CONTACT</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="filter-bar">
    <div class="dept-tabs">
        <button class="dept-tab active" data-dept="ALL">ALL</button>
        <?php foreach ($dept_order as $dept): ?>
            <button class="dept-tab" data-dept="<?php echo $dept; ?>"><?php echo $dept_labels[$dept]; ?></button>
        <?php endforeach; ?>
    </div>
    <div class="breadcrumb-trail">
        <span class="crumb active" data-level="all">All Work</span>
    </div>
</div>

<div class="video-feed" id="videoFeed">
    <?php foreach ($departments as $dept => $artists): ?>
        <?php foreach ($artists as $artist): ?>
            <div class="artist-divider" data-dept="<?php echo $dept; ?>" data-artist="<?php echo htmlspecialchars($artist['slug']); ?>">
                <span class="artist-divider-name"><?php echo htmlspecialchars($artist['name']); ?></span>
                <span class="artist-divider-dept"><?php echo $dept_labels[$dept]; ?></span>
            </div>
            <?php
            $videos = $artist['videos'] ?? [];
            usort($videos, function($a, $b) {
                return ($a['order'] ?? 0) - ($b['order'] ?? 0);
            });
            // Deduplicate videos by videoShort path
            $seen_paths = [];
            $unique_videos = [];
            foreach ($videos as $video) {
                $path = $video['videoShort'] ?? '';
                if ($path && !isset($seen_paths[$path])) {
                    $seen_paths[$path] = true;
                    $unique_videos[] = $video;
                } elseif (!$path) {
                    $unique_videos[] = $video;
                }
            }
            foreach ($unique_videos as $video):
                $video_key = ($video['videoName'] ?? '') . '|' . ($video['videoSubName'] ?? '');
                $simian_url = $simian_urls[$video_key] ?? '';
                $poster = $video['poster'] ?? '';
                $short_vid = $video['videoShort'] ?? '';
                $preview_images = $video['previewImages'] ?? ['','','','','',''];
            ?>
            <div class="video-card"
                 data-dept="<?php echo $dept; ?>"
                 data-artist="<?php echo htmlspecialchars($artist['slug']); ?>"
                 data-artist-name="<?php echo htmlspecialchars($artist['name']); ?>"
                 data-video-id="<?php echo htmlspecialchars($video['id'] ?? ''); ?>"
                 data-video-name="<?php echo htmlspecialchars($video['videoName'] ?? ''); ?>"
                 data-video-subname="<?php echo htmlspecialchars($video['videoSubName'] ?? ''); ?>"
                 data-simian-url="<?php echo htmlspecialchars($simian_url); ?>"
                 data-has-credit="<?php echo (!empty($video['hasCredit'])) ? 'yes' : 'no'; ?>"
                 data-credits="<?php echo htmlspecialchars($video['credits'] ?? ''); ?>"
                 data-prev1="<?php echo htmlspecialchars($preview_images[0] ?? ''); ?>"
                 data-prev2="<?php echo htmlspecialchars($preview_images[1] ?? ''); ?>"
                 data-prev3="<?php echo htmlspecialchars($preview_images[2] ?? ''); ?>"
                 data-prev4="<?php echo htmlspecialchars($preview_images[3] ?? ''); ?>"
                 data-prev5="<?php echo htmlspecialchars($preview_images[4] ?? ''); ?>"
                 data-prev6="<?php echo htmlspecialchars($preview_images[5] ?? ''); ?>">
                <video poster="/roster/<?php echo htmlspecialchars($poster); ?>"
                       src="/roster/<?php echo htmlspecialchars($short_vid); ?>"
                       muted autoplay loop playsinline webkit-playsinline></video>
                <label class="video-label"><?php
                    $name = $video['videoName'] ?? '';
                    $sub  = $video['videoSubName'] ?? '';
                    echo htmlspecialchars($sub ? "$name - $sub" : $name);
                ?></label>
            </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-video-wrap">
                    <div class="modal-simple" style="display:none;">
                        <iframe src="" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                        <h3 class="modal-title-main"></h3>
                        <h4 class="modal-title-sub"></h4>
                    </div>
                    <div class="modal-credit" style="display:none;">
                        <div class="credit-layout">
                            <div class="credit-left">
                                <h3 class="modal-title-main"></h3>
                                <iframe src="" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                            </div>
                            <div class="credit-right"></div>
                        </div>
                    </div>
                </div>
                <ul class="modal-screenshots"></ul>
            </div>
        </div>
    </div>
</div>

<script>
window.APOLLO_DATA = <?php echo json_encode($js_data, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/roster-v2/app.js?v=1.0.0"></script>
</body>
</html>
