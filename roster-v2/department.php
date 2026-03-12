<?php
// All-departments continuous horizontal scroll
$valid_depts = ['EDIT', 'COLOR', 'SOUND', 'VFX'];
$dept_roles = [
    'EDIT'  => 'Editor',
    'COLOR' => 'Colorist',
    'SOUND' => 'Sound Designer',
    'VFX'   => 'VFX Artist',
];

$artists_json = file_get_contents(__DIR__ . '/../data/artists.json');
$roster_json  = file_get_contents(__DIR__ . '/../data/roster.json');
$artists_data = json_decode($artists_json, true) ?: [];
$roster_data  = json_decode($roster_json, true) ?: [];

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

$artists_by_id = [];
foreach ($artists_data as $artist) {
    $artists_by_id[$artist['id']] = $artist;
}

// Build per-department data
$all_depts = [];
foreach ($valid_depts as $dept) {
    $dept_artists = [];
    if (isset($roster_data[$dept])) {
        foreach ($roster_data[$dept] as $artist_id) {
            if (isset($artists_by_id[$artist_id])) {
                $a = $artists_by_id[$artist_id];
                if (!empty($a['visible'])) {
                    $dept_artists[] = $a;
                }
            }
        }
    }
    usort($dept_artists, function($a, $b) {
        return ($a['order'] ?? 0) - ($b['order'] ?? 0);
    });

    $videos = [];
    foreach ($dept_artists as $artist) {
        $avids = $artist['videos'] ?? [];
        usort($avids, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        $seen = [];
        foreach ($avids as $v) {
            $path = $v['videoShort'] ?? '';
            if ($path && !isset($seen[$path])) {
                $seen[$path] = true;
                $v['_artist_name'] = $artist['name'];
                $v['_artist_slug'] = $artist['slug'];
                $videos[] = $v;
            }
        }
    }

    $all_depts[$dept] = [
        'artists' => $dept_artists,
        'videos'  => $videos,
    ];
}

// Offset generation helper
$h_sizes = [
    'w-lg', 'w-sm', 'w-xl', 'w-md', 'w-sm',
    'w-lg', 'w-md', 'w-sm', 'w-xl', 'w-md',
    'w-sm', 'w-lg', 'w-md', 'w-xl', 'w-sm',
    'w-md', 'w-lg', 'w-sm', 'w-xl', 'w-md',
];
$zones = [[0, 6], [10, 18], [22, 30]];

function generateOffsets($count, $seed_start) {
    global $zones;
    $offsets = [];
    $seed = $seed_start;
    $prev_zone = -1;
    for ($j = 0; $j < $count; $j++) {
        $seed = ($seed * 31 + 17) % 97;
        $available = [];
        for ($z = 0; $z < 3; $z++) {
            if ($z !== $prev_zone) $available[] = $z;
        }
        $pick = $available[$seed % count($available)];
        $seed = ($seed * 31 + 17) % 97;
        $rand = $seed / 97.0;
        $offsets[] = round($zones[$pick][0] + $rand * ($zones[$pick][1] - $zones[$pick][0]), 1);
        $prev_zone = $pick;
    }
    return $offsets;
}

// Determine starting dept from URL (for scroll-to on load)
$start_dept = strtoupper($_GET['dept'] ?? 'EDIT');
if (!in_array($start_dept, $valid_depts)) $start_dept = 'EDIT';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ROSTER | APOLLO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/roster-v2/style.css?v=6.8.0">
</head>
<body class="page-department" data-start-dept="<?php echo $start_dept; ?>">

<header>
    <div class="header-inner">
        <div class="header-logo">
            <a href="/"><img src="/fonts/logo.png" alt="Apollo"></a>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="/roster-v2/">ROSTER</a></li>
                <li><a href="/contact/">CONTACT</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="page-transition-overlay" id="pageTransition"></div>

<!-- Fixed hero: all dept titles + artist names stacked, driven by scroll -->
<div class="dept-hero anim-fade-up anim-delay-2">
    <div class="dept-hero-nav">
        <?php foreach ($valid_depts as $d): ?>
            <span class="dept-hero-title" data-dept="<?php echo $d; ?>"><?php echo $d; ?></span>
        <?php endforeach; ?>
    </div>
    <div class="dept-hero-artists-wrap">
        <?php foreach ($valid_depts as $d):
            $artists = $all_depts[$d]['artists'];
        ?>
        <div class="dept-hero-artists" data-dept="<?php echo $d; ?>">
            <?php foreach ($artists as $i => $artist): ?>
                <?php if ($i > 0): ?><span class="dept-hero-sep">/</span><?php endif; ?>
                <a class="dept-hero-artist" href="/roster-v2/artist.php?slug=<?php echo urlencode($artist['slug']); ?>&dept=<?php echo $d; ?>"><?php echo htmlspecialchars($artist['name']); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Horizontal scroll track with all departments -->
<div class="hscroll-wrap" id="hscrollWrap">
    <div class="hscroll-track anim-fade-in anim-delay-3" id="scatterFeed">
        <?php
        $dept_seeds = ['EDIT' => 7, 'COLOR' => 23, 'SOUND' => 41, 'VFX' => 59];
        $global_card_index = 0;
        foreach ($valid_depts as $di => $dept):
            $dept_data = $all_depts[$dept];
            $videos = $dept_data['videos'];
            $offsets = generateOffsets(count($videos), $dept_seeds[$dept]);

            if ($di > 0): ?>
            <?php endif; ?>

        <div class="dept-section" data-dept="<?php echo $dept; ?>">
            <?php foreach ($videos as $i => $video):
                $video_key = ($video['videoName'] ?? '') . '|' . ($video['videoSubName'] ?? '');
                $simian_url = $simian_urls[$video_key] ?? '';
                $poster = $video['poster'] ?? '';
                $short_vid = $video['videoShort'] ?? '';
                $preview_images = $video['previewImages'] ?? ['','','','','',''];
                $name = $video['videoName'] ?? '';
                $sub  = $video['videoSubName'] ?? '';
                $title = htmlspecialchars($sub ? "$name - $sub" : $name);
                $wsize = $h_sizes[$global_card_index % count($h_sizes)];
                $voffset = $offsets[$i] ?? 15;
                $global_card_index++;
            ?>
            <div class="hcard <?php echo $wsize; ?>" style="margin-top: <?php echo $voffset; ?>vh;"
                 data-artist="<?php echo htmlspecialchars($video['_artist_slug']); ?>"
                 data-artist-name="<?php echo htmlspecialchars($video['_artist_name']); ?>"
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
                       <?php if ($global_card_index <= 8): ?>src="/roster/<?php echo htmlspecialchars($short_vid); ?>"<?php endif; ?>
                       data-src="/roster/<?php echo htmlspecialchars($short_vid); ?>"
                       muted autoplay loop playsinline webkit-playsinline></video>
                <div class="hcard-overlay">
                    <span class="hcard-title"><?php echo $title; ?></span>
                    <span class="hcard-artist"><?php echo htmlspecialchars($video['_artist_name']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal (shared) -->
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/roster-v2/app.js?v=6.8.0"></script>
</body>
</html>
