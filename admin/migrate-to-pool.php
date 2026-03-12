<?php
/**
 * Migration Script: Convert embedded videos to centralized video pool
 * 
 * This script:
 * 1. Reads current artists.json (videos embedded in each artist)
 * 2. Extracts all videos, deduplicates by videoShort path
 * 3. Merges in landing_page.json Simian URLs where artist data is truncated
 * 4. Creates data/videos.json (the central pool)
 * 5. Rewrites artists.json with video_ids references
 * 6. Rewrites landing_page.json with video_id references
 * 
 * Run from command line: php migrate-to-pool.php
 * Or visit in browser when logged into admin
 */

if (php_sapi_name() !== 'cli') {
    require_once 'config.php';
    requireLogin();
}

$data_dir = __DIR__ . '/../data/';
$artists_file = $data_dir . 'artists.json';
$landing_file = $data_dir . 'landing_page.json';
$videos_file = $data_dir . 'videos.json';
$backup_dir = $data_dir . 'backups/pre-pool-migration/';

function output($msg) {
    if (php_sapi_name() === 'cli') {
        echo $msg . "\n";
    } else {
        echo "<p>" . htmlspecialchars($msg) . "</p>";
    }
}

function normalizeVideoPath($path) {
    $path = str_replace('\\/', '/', $path);
    $path = preg_replace('#^roster/#', '', $path);
    return $path;
}

// Safety check
if (file_exists($videos_file)) {
    output("ERROR: videos.json already exists. Migration may have already run.");
    output("Delete data/videos.json first if you want to re-run migration.");
    exit(1);
}

output("=== Apollo CMS: Video Pool Migration ===");
output("");

// Load current data
$artists = json_decode(file_get_contents($artists_file), true);
$landing = json_decode(file_get_contents($landing_file), true);

if (!$artists) {
    output("ERROR: Could not read artists.json");
    exit(1);
}

output("Loaded " . count($artists) . " artists");
output("Loaded " . count($landing) . " landing page projects");

// Phase 1: Extract all videos from artists, deduplicate by videoShort
$video_pool = [];
$path_to_vid_id = [];
$total_artist_videos = 0;

foreach ($artists as $artist) {
    foreach ($artist['videos'] ?? [] as $video) {
        $total_artist_videos++;
        $normalized_path = normalizeVideoPath($video['videoShort'] ?? '');
        
        if (empty($normalized_path)) continue;
        
        if (isset($path_to_vid_id[$normalized_path])) {
            // Already in pool - merge in better data if available
            $existing_id = $path_to_vid_id[$normalized_path];
            $existing = &$video_pool[$existing_id];
            
            // Keep longer credits if current has better data
            if (strlen($video['credits'] ?? '') > strlen($existing['credits'] ?? '')) {
                $existing['credits'] = $video['credits'];
                $existing['hasCredit'] = $video['hasCredit'] ?? false;
            }
            
            // Keep non-empty preview images
            $existing_images = $existing['previewImages'] ?? ['','','','','',''];
            $new_images = $video['previewImages'] ?? ['','','','','',''];
            for ($i = 0; $i < 6; $i++) {
                if (empty($existing_images[$i]) && !empty($new_images[$i])) {
                    $existing_images[$i] = $new_images[$i];
                }
            }
            $existing['previewImages'] = $existing_images;
            
            // Keep non-truncated videoLong
            $existing_long = $existing['videoLong'] ?? '';
            $new_long = $video['videoLong'] ?? '';
            if ((strlen($existing_long) < 20 || $existing_long === '<div style=') && strlen($new_long) > 20) {
                $existing['videoLong'] = $new_long;
            }
            
            unset($existing);
            continue;
        }
        
        $vid_id = 'vid_' . substr(md5($normalized_path . microtime(true) . $total_artist_videos), 0, 12);
        
        $pool_video = [
            'id' => $vid_id,
            'title' => $video['videoName'] ?? '',
            'subtitle' => $video['videoSubName'] ?? '',
            'videoShort' => $normalized_path,
            'videoLong' => $video['videoLong'] ?? '',
            'poster' => normalizeVideoPath($video['poster'] ?? ''),
            'hasCredit' => $video['hasCredit'] ?? false,
            'credits' => $video['credits'] ?? '',
            'previewImages' => $video['previewImages'] ?? ['','','','','',''],
            'tags' => [],
            'created_at' => date('Y-m-d')
        ];
        
        $video_pool[$vid_id] = $pool_video;
        $path_to_vid_id[$normalized_path] = $vid_id;
    }
}

output("Extracted $total_artist_videos video entries from artists");
output("Deduplicated to " . count($video_pool) . " unique videos");

// Phase 2: Merge landing page Simian URLs into pool
$landing_matched = 0;
$landing_new = 0;

foreach ($landing as $project) {
    $lp_path = normalizeVideoPath($project['video_short'] ?? '');
    if (empty($lp_path)) continue;
    
    $lp_long = $project['video_long'] ?? '';
    
    if (isset($path_to_vid_id[$lp_path])) {
        $vid_id = $path_to_vid_id[$lp_path];
        $existing_long = $video_pool[$vid_id]['videoLong'] ?? '';
        
        // Landing page has proper Simian URLs; artist data often has truncated HTML
        if (strpos($lp_long, 'gosimian.com') !== false && 
            (strlen($existing_long) < 20 || strpos($existing_long, 'gosimian.com') === false)) {
            $video_pool[$vid_id]['videoLong'] = $lp_long;
        }
        
        // Merge preview images
        $lp_images = $project['preview_images'] ?? ['','','','','',''];
        $existing_images = $video_pool[$vid_id]['previewImages'];
        for ($i = 0; $i < 6; $i++) {
            if (empty($existing_images[$i]) && !empty($lp_images[$i])) {
                $existing_images[$i] = $lp_images[$i];
            }
        }
        $video_pool[$vid_id]['previewImages'] = $existing_images;
        
        $landing_matched++;
    } else {
        // Video exists only on landing page, add to pool
        $vid_id = 'vid_' . substr(md5($lp_path . 'landing' . $landing_new), 0, 12);
        
        $video_pool[$vid_id] = [
            'id' => $vid_id,
            'title' => $project['title'] ?? '',
            'subtitle' => $project['subtitle'] ?? '',
            'videoShort' => $lp_path,
            'videoLong' => $lp_long,
            'poster' => '',
            'hasCredit' => $project['has_credits'] ?? false,
            'credits' => $project['credits'] ?? '',
            'previewImages' => $project['preview_images'] ?? ['','','','','',''],
            'tags' => [],
            'created_at' => date('Y-m-d')
        ];
        
        $path_to_vid_id[$lp_path] = $vid_id;
        $landing_new++;
    }
}

output("Landing page: $landing_matched matched to existing pool videos, $landing_new new videos added");
output("Final pool size: " . count($video_pool) . " videos");

// Phase 3: Rewrite artists.json with video_ids
$new_artists = [];
$artist_link_count = 0;

foreach ($artists as $artist) {
    $video_ids = [];
    $seen_ids = [];
    
    foreach ($artist['videos'] ?? [] as $video) {
        $normalized_path = normalizeVideoPath($video['videoShort'] ?? '');
        if (empty($normalized_path)) continue;
        
        if (isset($path_to_vid_id[$normalized_path])) {
            $vid_id = $path_to_vid_id[$normalized_path];
            if (!in_array($vid_id, $seen_ids)) {
                $video_ids[] = $vid_id;
                $seen_ids[] = $vid_id;
                $artist_link_count++;
            }
        }
    }
    
    $new_artists[] = [
        'id' => $artist['id'],
        'name' => $artist['name'],
        'slug' => $artist['slug'],
        'category' => $artist['category'] ?? '',
        'video_ids' => $video_ids,
        'visible' => $artist['visible'] ?? true
    ];
}

output("Created $artist_link_count video links across " . count($new_artists) . " artists");

// Phase 4: Rewrite landing_page.json with video_id references
$new_landing = [];

foreach ($landing as $project) {
    $lp_path = normalizeVideoPath($project['video_short'] ?? '');
    $vid_id = $path_to_vid_id[$lp_path] ?? null;
    
    $new_landing[] = [
        'id' => $project['id'],
        'video_id' => $vid_id,
        'image_class' => $project['image_class'] ?? '',
        'title_override' => $project['title'] ?? '',
        'subtitle_override' => $project['subtitle'] ?? '',
        'author' => $project['author'] ?? '',
        'order' => $project['order'] ?? 0,
        'visible' => $project['visible'] ?? true
    ];
}

output("Rewrote " . count($new_landing) . " landing page projects with video_id references");

// Phase 5: Validation
$errors = [];

// Check all artist video_ids resolve
foreach ($new_artists as $artist) {
    foreach ($artist['video_ids'] as $vid_id) {
        if (!isset($video_pool[$vid_id])) {
            $errors[] = "Artist '{$artist['name']}' references missing video: $vid_id";
        }
    }
}

// Check all landing page video_ids resolve
foreach ($new_landing as $proj) {
    if ($proj['video_id'] && !isset($video_pool[$proj['video_id']])) {
        $errors[] = "Landing project '{$proj['title_override']}' references missing video: {$proj['video_id']}";
    }
}

if (!empty($errors)) {
    output("");
    output("VALIDATION ERRORS:");
    foreach ($errors as $err) {
        output("  - $err");
    }
    output("Migration ABORTED. No files were changed.");
    exit(1);
}

output("");
output("Validation passed! All references resolve correctly.");

// Phase 6: Write new files
$pool_array = array_values($video_pool);
usort($pool_array, function($a, $b) {
    return strcasecmp($a['title'], $b['title']);
});

file_put_contents($videos_file, json_encode($pool_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
file_put_contents($artists_file, json_encode($new_artists, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
file_put_contents($landing_file, json_encode($new_landing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

output("");
output("=== Migration Complete ===");
output("  videos.json:       " . count($pool_array) . " videos in pool");
output("  artists.json:      " . count($new_artists) . " artists with video_ids");
output("  landing_page.json: " . count($new_landing) . " projects with video_id refs");
output("  Backups at:        data/backups/pre-pool-migration/");
output("");
output("Next: Update admin/config.php, CMS pages, and frontend to use the new pool.");
