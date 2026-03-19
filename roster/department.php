<?php
// All-departments continuous horizontal scroll
$valid_depts = ['EDIT', 'COLOR', 'SOUND', 'VFX'];
$dept_roles = [
    'EDIT'  => 'Editor',
    'COLOR' => 'Colorist',
    'SOUND' => 'Sound Designer',
    'VFX'   => 'VFX Artist',
];

$artists_data    = json_decode(file_get_contents(__DIR__ . '/../data/artists.json'), true) ?: [];
$roster_data     = json_decode(file_get_contents(__DIR__ . '/../data/roster.json'), true) ?: [];
$videos_pool     = json_decode(file_get_contents(__DIR__ . '/../data/videos.json'), true) ?: [];
$roster_featured_path = __DIR__ . '/../data/roster_featured.json';
$roster_featured = file_exists($roster_featured_path) ? (json_decode(file_get_contents($roster_featured_path), true) ?: []) : [];

$videos_by_id = [];
foreach ($videos_pool as $vp) {
    $videos_by_id[$vp['id']] = $vp;
}


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

    $featured_ids = $roster_featured[$dept] ?? [];
    $videos = [];
    $seen = [];

    if (!empty($featured_ids)) {
        foreach ($featured_ids as $vid) {
            if (!isset($videos_by_id[$vid])) continue;
            $pool_video = $videos_by_id[$vid];
            $vlong = $pool_video['videoLong'] ?? '';
            $aspect = 'landscape';
            if (preg_match('/padding-bottom:([\d.]+)%/', $vlong, $_pb) && floatval($_pb[1]) > 100) {
                $aspect = 'portrait';
            }
            $artist_name = '';
            $artist_slug = '';
            foreach ($artists_data as $a) {
                if (in_array($vid, $a['video_ids'] ?? [])) {
                    $artist_name = $a['name'];
                    $artist_slug = $a['slug'];
                    break;
                }
            }
            $path = $pool_video['videoShort'] ?? '';
            if ($path && !isset($seen[$path])) {
                $seen[$path] = true;
                $videos[] = [
                    'videoName'     => $pool_video['title'] ?? '',
                    'videoSubName'  => $pool_video['subtitle'] ?? '',
                    'videoShort'    => $path,
                    'poster'        => $pool_video['poster'] ?? '',
                    'hasCredit'     => $pool_video['hasCredit'] ?? false,
                    'credits'       => $pool_video['credits'] ?? '',
                    'previewImages' => $pool_video['previewImages'] ?? [],
                    '_aspect'       => $aspect,
                    '_videoLong'    => $vlong,
                    '_artist_name'  => $artist_name,
                    '_artist_slug'  => $artist_slug,
                ];
            }
        }
    } else {
        foreach ($dept_artists as $artist) {
            foreach ($artist['video_ids'] ?? [] as $vid) {
                if (!isset($videos_by_id[$vid])) continue;
                $pool_video = $videos_by_id[$vid];
                $vlong = $pool_video['videoLong'] ?? '';
                $aspect = 'landscape';
                if (preg_match('/padding-bottom:([\d.]+)%/', $vlong, $_pb) && floatval($_pb[1]) > 100) {
                    $aspect = 'portrait';
                }
                $path = $pool_video['videoShort'] ?? '';
                if ($path && !isset($seen[$path])) {
                    $seen[$path] = true;
                    $videos[] = [
                        'videoName'     => $pool_video['title'] ?? '',
                        'videoSubName'  => $pool_video['subtitle'] ?? '',
                        'videoShort'    => $path,
                        'poster'        => $pool_video['poster'] ?? '',
                        'hasCredit'     => $pool_video['hasCredit'] ?? false,
                        'credits'       => $pool_video['credits'] ?? '',
                        'previewImages' => $pool_video['previewImages'] ?? [],
                        '_aspect'       => $aspect,
                        '_videoLong'    => $vlong,
                        '_artist_name'  => $artist['name'],
                        '_artist_slug'  => $artist['slug'],
                    ];
                }
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
$zones = [[0, 5], [8, 16], [18, 25]];

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
    <link rel="stylesheet" href="/roster/style-v2.css?v=11.0.0">
</head>
<body class="page-department" data-start-dept="<?php echo $start_dept; ?>">

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
                <?php if ($i > 0): ?><span class="dept-hero-sep">·</span><?php endif; ?>
                <a class="dept-hero-artist" href="/roster/artist-page.php?slug=<?php echo urlencode($artist['slug']); ?>&dept=<?php echo $d; ?>"><?php echo htmlspecialchars($artist['name']); ?></a>
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
                $poster = $video['poster'] ?? '';
                $short_vid = $video['videoShort'] ?? '';
                $preview_images = ($dept === 'COLOR') ? ($video['previewImages'] ?? ['','','','','','']) : ['','','','','',''];
                $name = $video['videoName'] ?? '';
                $sub  = $video['videoSubName'] ?? '';
                $title = htmlspecialchars($sub ? "$name - $sub" : $name);
                $wsize = $h_sizes[$global_card_index % count($h_sizes)];
                $voffset = $offsets[$i] ?? 15;
                $max_offset_by_size = ['w-xl' => 5, 'w-lg' => 12, 'w-md' => 20, 'w-sm' => 25];
                $voffset = min($voffset, $max_offset_by_size[$wsize] ?? 15);
                $global_card_index++;
            ?>
            <div class="hcard <?php echo $wsize; ?>" style="margin-top: <?php echo $voffset; ?>vh;"
                 data-artist="<?php echo htmlspecialchars($video['_artist_slug']); ?>"
                 data-artist-name="<?php echo htmlspecialchars($video['_artist_name']); ?>"
                 data-video-name="<?php echo htmlspecialchars($video['videoName'] ?? ''); ?>"
                 data-video-subname="<?php echo htmlspecialchars($video['videoSubName'] ?? ''); ?>"
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
                       <?php if ($global_card_index <= 2): ?>src="/roster/<?php echo htmlspecialchars($short_vid); ?>"<?php endif; ?>
                       data-src="/roster/<?php echo htmlspecialchars($short_vid); ?>"
                       data-card-index="<?php echo $global_card_index; ?>"
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

<!-- Scroll hint (mobile only) -->
<div class="mobile-scroll-hint" id="mobileScrollHint">
    <span>Swipe to explore</span>
    <svg width="40" height="12" viewBox="0 0 40 12" fill="none">
        <path d="M0 6H38M38 6L32 1M38 6L32 11" stroke="rgba(255,255,255,0.35)" stroke-width="1"/>
    </svg>
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
<script src="/roster/app-v2.js?v=11.1.0"></script>
</body>
</html>
