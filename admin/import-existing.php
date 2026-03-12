<?php
require_once 'config.php';
requireLogin();

$message = '';
$errors = [];
$imported_artists = 0;
$imported_videos = 0;
$imported_projects = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {
    // Define existing artists based on work/index.php
    $existing_artists_data = [
        // EDIT category
        ['name' => 'Devon Solwold', 'slug' => 'devon-solwold', 'category' => 'EDIT', 'order' => 0],
        ['name' => 'Griffin Olis', 'slug' => 'griffin-olis', 'category' => 'EDIT', 'order' => 1],
        ['name' => 'Liam Tangum', 'slug' => 'liam-tangum', 'category' => 'EDIT', 'order' => 2],
        ['name' => 'Jamil Shaukat', 'slug' => 'jamil-shaukat', 'category' => 'EDIT', 'order' => 3],
        ['name' => 'Nasser Boulaich', 'slug' => 'nasser-boulaich', 'category' => 'EDIT', 'order' => 4],
        ['name' => 'Zack Pelletier', 'slug' => 'zack-pelletier', 'category' => 'EDIT', 'order' => 5],
        // COLOR category
        ['name' => 'Avery Niles', 'slug' => 'avery-niles', 'category' => 'COLOR', 'order' => 0],
        ['name' => 'Wilhends Norvil', 'slug' => 'wilhends-norvil', 'category' => 'COLOR', 'order' => 1],
        // SOUND category
        ['name' => 'Ayo Douson', 'slug' => 'ayo-douson', 'category' => 'SOUND', 'order' => 0],
        // VFX category
        ['name' => 'Ben Gillespie', 'slug' => 'ben-gillespie', 'category' => 'VFX', 'order' => 0],
        ['name' => 'Le Jumper', 'slug' => 'le-jumper', 'category' => 'VFX', 'order' => 1],
    ];
    
    $artists = [];
    
    // Function to extract videos from artist page HTML
    function extractVideosFromPage($file_path, $artist_name) {
        if (!file_exists($file_path)) {
            return [];
        }
        
        $content = file_get_contents($file_path);
        $videos = [];
        
        // Split content by video divs - look for pattern: <div class="video
        $video_blocks = preg_split('/(<div class="video[^>]*>)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        for ($i = 1; $i < count($video_blocks); $i += 2) {
            if (!isset($video_blocks[$i]) || !isset($video_blocks[$i + 1])) continue;
            
            $video_tag = $video_blocks[$i] . $video_blocks[$i + 1];
            
            // Extract data attributes
            $data = [];
            $attributes = ['longVideo', 'title', 'author', 'videoName', 'videoSubName', 'credit', 'credits'];
            foreach ($attributes as $attr) {
                // Try both single and double quotes
                if (preg_match('/data-' . $attr . '=[\'"]([^\'"]*)[\'"]/', $video_tag, $match)) {
                    $data[$attr] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                } elseif (preg_match('/data-' . $attr . '=\'([^\']*)\'/', $video_tag, $match)) {
                    $data[$attr] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                } else {
                    $data[$attr] = '';
                }
            }
            
            // Extract preview images
            $preview_images = [];
            for ($j = 1; $j <= 6; $j++) {
                if (preg_match('/data-prev' . $j . '=[\'"]([^\'"]*)[\'"]/', $video_tag, $match)) {
                    $preview_images[] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                } elseif (preg_match('/data-prev' . $j . '=\'([^\']*)\'/', $video_tag, $match)) {
                    $preview_images[] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                } else {
                    $preview_images[] = '';
                }
            }
            
            // Extract video element attributes
            $poster = '';
            $video_short = '';
            
            if (preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*src=[\'"]([^\'"]*)[\'"]/', $video_tag, $match)) {
                $poster = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $video_short = html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            } elseif (preg_match('/<video[^>]*src=[\'"]([^\'"]*)[\'"][^>]*poster=[\'"]([^\'"]*)[\'"]/', $video_tag, $match)) {
                $video_short = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $poster = html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            } elseif (preg_match('/src=[\'"]([^\'"]*)[\'"]/', $video_tag, $match)) {
                $video_short = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
            
            // Extract label text
            $label = '';
            if (preg_match('/<label>([^<]*)<\/label>/', $video_tag, $match)) {
                $label = trim(html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }
            
            // Only add if we have essential data
            if (!empty($data['videoName']) || !empty($label)) {
                $videos[] = [
                    'id' => uniqid('video_'),
                    'videoName' => !empty($data['videoName']) ? $data['videoName'] : $label,
                    'videoSubName' => $data['videoSubName'] ?? '',
                    'videoShort' => $video_short,
                    'videoLong' => $data['longVideo'] ?? '',
                    'poster' => $poster,
                    'hasCredit' => ($data['credit'] ?? '') === 'yes',
                    'credits' => $data['credits'] ?? '',
                    'previewImages' => $preview_images,
                    'order' => count($videos)
                ];
            }
        }
        
        return $videos;
    }
    
    // Import each artist
    foreach ($existing_artists_data as $artist_data) {
        $artist_file = __DIR__ . '/../roster/' . $artist_data['slug'] . '.php';
        $videos = extractVideosFromPage($artist_file, $artist_data['name']);
        
        if (count($videos) > 0 || file_exists($artist_file)) {
            $artists[] = [
                'id' => uniqid('artist_'),
                'name' => $artist_data['name'],
                'slug' => $artist_data['slug'],
                'category' => $artist_data['category'],
                'videos' => $videos,
                'order' => $artist_data['order'],
                'visible' => true
            ];
            
            $imported_artists++;
            $imported_videos += count($videos);
        }
    }
    
    // Save artists
    saveArtists($artists);
    
    // Now import landing page projects from index.php
    $index_file = __DIR__ . '/../index.php';
    if (file_exists($index_file)) {
        $content = file_get_contents($index_file);
        $projects = [];
        
        // Find all backgroundImage divs
        preg_match_all('/<div class="backgroundImage ([^"]*)"[^>]*>(.*?)<\/div>/s', $content, $div_matches, PREG_SET_ORDER);
        
        foreach ($div_matches as $idx => $div_match) {
            $image_class = trim($div_match[1]);
            $div_content = $div_match[2];
            
            // Extract openModelItem link data
            if (preg_match('/<a class="openModelItem"[^>]*>/', $div_content, $link_match)) {
                $link_tag = $link_match[0];
                
                // Extract all data attributes
                $data = [];
                $attributes = ['image', 'prev1', 'prev2', 'prev3', 'prev4', 'prev5', 'prev6', 'long', 'author', 'title', 'subtitle', 'credit', 'credits'];
                foreach ($attributes as $attr) {
                    if (preg_match('/data-' . $attr . '=[\'"]([^\'"]*)[\'"]/', $link_tag, $match)) {
                        $data[$attr] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    } elseif (preg_match('/data-' . $attr . '=\'([^\']*)\'/', $link_tag, $match)) {
                        $data[$attr] = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    } else {
                        $data[$attr] = '';
                    }
                }
                
                // Extract video src
                $video_short = '';
                if (preg_match('/<video[^>]*src=[\'"]([^\'"]*)[\'"]/', $div_content, $match)) {
                    $video_short = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
                
                if (!empty($data['title'])) {
                    $projects[] = [
                        'id' => uniqid('proj_'),
                        'image_class' => !empty($data['image']) ? $data['image'] : $image_class,
                        'title' => $data['title'],
                        'subtitle' => $data['subtitle'] ?? '',
                        'author' => $data['author'] ?? '',
                        'video_short' => $video_short,
                        'video_long' => $data['long'] ?? '',
                        'has_credits' => ($data['credit'] ?? '') === 'yes',
                        'credits' => $data['credits'] ?? '',
                        'preview_images' => [
                            $data['prev1'] ?? '',
                            $data['prev2'] ?? '',
                            $data['prev3'] ?? '',
                            $data['prev4'] ?? '',
                            $data['prev5'] ?? '',
                            $data['prev6'] ?? ''
                        ],
                        'order' => $idx,
                        'visible' => true
                    ];
                }
            }
        }
        
        saveLandingPageProjects($projects);
        $imported_projects = count($projects);
    }
    
    $message = '<div class="alert alert-success"><h4><i class="fas fa-check-circle"></i> Import Complete!</h4><p>Successfully imported:</p><ul><li><strong>' . $imported_artists . '</strong> artists</li><li><strong>' . $imported_videos . '</strong> videos</li><li><strong>' . $imported_projects . '</strong> landing page projects</li></ul><p class="mt-3"><a href="artists.php" class="btn btn-primary">View Artists</a> <a href="landing-page.php" class="btn btn-primary">View Landing Page</a> <a href="sync.php" class="btn btn-success">Sync to Website</a></p></div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Existing Content - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-download"></i> Import Existing Content</h1>
        </div>
        
        <?php echo $message; ?>
        
        <div class="content-card">
            <h2>Import from Existing Website</h2>
            <p>This will extract all existing artists, videos, and landing page projects from your current website files and import them into the CMS.</p>
            
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Note:</strong> This will overwrite any existing CMS data. Make sure you want to proceed.
            </div>
            
            <h3>What will be imported:</h3>
            <ul>
                <li><strong>Artists:</strong>
                    <ul>
                        <li><strong>EDIT:</strong> Devon Solwold, Griffin Olis, Liam Tangum, Jamil Shaukat, Nasser Boulaich, Zack Pelletier</li>
                        <li><strong>COLOR:</strong> Avery Niles, Wilhends Norvil</li>
                        <li><strong>SOUND:</strong> Ayo Douson</li>
                        <li><strong>VFX:</strong> Ben Gillespie, Le Jumper</li>
                    </ul>
                </li>
                <li><strong>Videos:</strong> All videos from each artist's roster page (roster/[artist-slug].php)</li>
                <li><strong>Landing Page Projects:</strong> All featured projects from index.php</li>
            </ul>
            
            <form method="POST" onsubmit="return confirm('This will overwrite all existing CMS data. Are you sure you want to continue?');">
                <button type="submit" name="import" class="btn-primary btn-lg">
                    <i class="fas fa-download"></i> Import Now
                </button>
            </form>
        </div>
        
        <div class="content-card">
            <h3>Current CMS Status</h3>
            <?php
            $current_artists = getArtists();
            $current_projects = getLandingPageProjects();
            $total_videos = 0;
            foreach ($current_artists as $a) {
                $total_videos += count($a['videos'] ?? []);
            }
            ?>
            <ul>
                <li>Artists: <strong><?php echo count($current_artists); ?></strong></li>
                <li>Videos: <strong><?php echo $total_videos; ?></strong></li>
                <li>Landing Page Projects: <strong><?php echo count($current_projects); ?></strong></li>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
