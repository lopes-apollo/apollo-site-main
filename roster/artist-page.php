<?php
// Artist Page — Vertical scroll with rolling scale/opacity animation
// Usage: artist.php?slug=devon-solwold&dept=EDIT

$slug = $_GET['slug'] ?? '';
$dept_param = strtoupper($_GET['dept'] ?? '');

$artists_json = file_get_contents(__DIR__ . '/../data/artists.json');
$roster_json  = file_get_contents(__DIR__ . '/../data/roster.json');
$videos_json  = file_get_contents(__DIR__ . '/../data/videos.json');
$artists_data = json_decode($artists_json, true) ?: [];
$roster_data  = json_decode($roster_json, true) ?: [];
$videos_pool  = json_decode($videos_json, true) ?: [];

$videos_by_id = [];
foreach ($videos_pool as $vp) {
    $videos_by_id[$vp['id']] = $vp;
}

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

$current_artist = null;
$artist_dept = $dept_param;
foreach ($artists_data as $artist) {
    if ($artist['slug'] === $slug) {
        $current_artist = $artist;
        break;
    }
}

if (!$current_artist) {
    header('Location: /work/');
    exit;
}

// Find department if not provided
if (!$artist_dept) {
    foreach ($roster_data as $dept => $ids) {
        if (in_array($current_artist['id'], $ids)) {
            $artist_dept = $dept;
            break;
        }
    }
}

$video_ids = $current_artist['video_ids'] ?? [];
$seen_paths = [];
$unique_videos = [];
foreach ($video_ids as $vid) {
    if (!isset($videos_by_id[$vid])) continue;
    $pool_video = $videos_by_id[$vid];
    $vlong = $pool_video['videoLong'] ?? '';
    $aspect = 'landscape';
    if (preg_match('/padding-bottom:([\d.]+)%/', $vlong, $_pb) && floatval($_pb[1]) > 100) {
        $aspect = 'portrait';
    }
    $video = [
        'videoName'     => $pool_video['title'] ?? '',
        'videoSubName'  => $pool_video['subtitle'] ?? '',
        'videoShort'    => $pool_video['videoShort'] ?? '',
        'poster'        => $pool_video['poster'] ?? '',
        'hasCredit'     => $pool_video['hasCredit'] ?? false,
        'credits'       => $pool_video['credits'] ?? '',
        'previewImages' => $pool_video['previewImages'] ?? [],
        '_aspect'       => $aspect,
        '_videoLong'    => $vlong,
    ];
    $path = $video['videoShort'];
    if ($path && !isset($seen_paths[$path])) {
        $seen_paths[$path] = true;
        $unique_videos[] = $video;
    } elseif (!$path) {
        $unique_videos[] = $video;
    }
}

// Get all artists in this department for the sidebar
$dept_artist_ids = $roster_data[$artist_dept] ?? [];
$artists_by_id = [];
foreach ($artists_data as $a) {
    $artists_by_id[$a['id']] = $a;
}
$sibling_artists = [];
foreach ($dept_artist_ids as $aid) {
    if (isset($artists_by_id[$aid]) && !empty($artists_by_id[$aid]['visible'])) {
        $sibling_artists[] = $artists_by_id[$aid];
    }
}
usort($sibling_artists, function($a, $b) {
    return ($a['order'] ?? 0) - ($b['order'] ?? 0);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($current_artist['name']); ?> | APOLLO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/roster/style-v2.css?v=8.0.0">
</head>
<body class="page-artist">

<header>
    <div class="header-inner">
        <div class="header-logo">
            <a href="/"><img src="/fonts/logo.png" alt="Apollo"></a>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="/roster/department.php">ROSTER</a></li>
                <li><a href="/contact/">CONTACT</a></li>
            </ul>
        </nav>
    </div>
</header>

<?php
$dept_roles = [
    'EDIT'  => 'Editor',
    'COLOR' => 'Colorist',
    'SOUND' => 'Sound Designer',
    'VFX'   => 'VFX Artist',
];
$role_label = $dept_roles[$artist_dept] ?? $artist_dept;
?>

<div class="artist-hero artist-hero--solo">
    <h1 class="artist-hero-name"><?php echo htmlspecialchars($current_artist['name']); ?></h1>
    <span class="artist-hero-role"><?php echo htmlspecialchars($role_label); ?></span>
</div>

<div class="video-feed artist-feed" id="videoFeed">
    <?php foreach ($unique_videos as $video):
        $video_key = ($video['videoName'] ?? '') . '|' . ($video['videoSubName'] ?? '');
        $simian_url = $simian_urls[$video_key] ?? '';
        $poster = $video['poster'] ?? '';
        $short_vid = $video['videoShort'] ?? '';
        $preview_images = $video['previewImages'] ?? ['','','','','',''];
    ?>
    <div class="video-card"
         data-artist="<?php echo htmlspecialchars($slug); ?>"
         data-artist-name="<?php echo htmlspecialchars($current_artist['name']); ?>"
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
         data-prev6="<?php echo htmlspecialchars($preview_images[5] ?? ''); ?>"
         data-aspect="<?php echo $video['_aspect'] ?? 'landscape'; ?>"
         data-embed="<?php echo htmlspecialchars($video['_videoLong'] ?? ''); ?>">
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
</div>

<!-- Modal (shared) -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="vmodal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1 1L19 19M19 1L1 19" stroke="#fff" stroke-width="1.5"/></svg>
            </button>
            <div class="modal-body">
                <div class="vmodal-info">
                    <h2 class="vmodal-title"></h2>
                    <div class="vmodal-tags"></div>
                </div>
                <div class="vmodal-player"></div>
                <div class="vmodal-credits-bar" style="display:none;">
                    <div class="vmodal-credits-content"></div>
                </div>
                <ul class="vmodal-screenshots"></ul>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/roster/app-v2.js?v=8.0.0"></script>
</body>
</html>
