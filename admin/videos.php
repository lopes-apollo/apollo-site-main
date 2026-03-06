<?php
require_once 'config.php';
requireLogin();

// Collect all videos from all artists
$artists = getArtists();
$all_videos = [];

foreach ($artists as $artist) {
    $videos = $artist['videos'] ?? [];
    foreach ($videos as $video) {
        $video['artist_name'] = $artist['name'];
        $video['artist_category'] = $artist['category'] ?? '';
        $video['artist_slug'] = $artist['slug'] ?? '';
        $video['artist_id'] = $artist['id'] ?? '';
        $all_videos[] = $video;
    }
}

// Handle video updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_video') {
    $video_id = $_POST['video_id'] ?? '';
    $artist_id = $_POST['artist_id'] ?? '';
    
    if ($video_id && $artist_id) {
        foreach ($artists as $key => $artist) {
            if ($artist['id'] === $artist_id) {
                foreach ($artist['videos'] as $vkey => $video) {
                    if ($video['id'] === $video_id) {
                        $artists[$key]['videos'][$vkey]['videoName'] = $_POST['videoName'] ?? $video['videoName'];
                        $artists[$key]['videos'][$vkey]['videoSubName'] = $_POST['videoSubName'] ?? $video['videoSubName'];
                        $artists[$key]['videos'][$vkey]['videoShort'] = $_POST['videoShort'] ?? $video['videoShort'];
                        $artists[$key]['videos'][$vkey]['videoLong'] = $_POST['videoLong'] ?? $video['videoLong'];
                        $artists[$key]['videos'][$vkey]['poster'] = $_POST['poster'] ?? $video['poster'];
                        $artists[$key]['videos'][$vkey]['hasCredit'] = isset($_POST['hasCredit']);
                        $artists[$key]['videos'][$vkey]['credits'] = $_POST['credits'] ?? $video['credits'];
                        break 2;
                    }
                }
            }
        }
        saveArtists($artists);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Video updated successfully!</div>';
        // Refresh data
        $artists = getArtists();
        // Rebuild all_videos array
        $all_videos = [];
        foreach ($artists as $artist) {
            $videos = $artist['videos'] ?? [];
            foreach ($videos as $video) {
                $video['artist_name'] = $artist['name'];
                $video['artist_category'] = $artist['category'] ?? '';
                $video['artist_slug'] = $artist['slug'] ?? '';
                $video['artist_id'] = $artist['id'] ?? '';
                $all_videos[] = $video;
            }
        }
    }
}

// Helper function to format file size
function formatFileSize($bytes) {
    if ($bytes == 0) return '0 B';
    $k = 1024;
    $sizes = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}

// Helper function to get file size if file exists
function getVideoFileSize($file_path) {
    $full_path = __DIR__ . '/../' . $file_path;
    if (file_exists($full_path)) {
        return filesize($full_path);
    }
    return 0;
}

// Helper function to recursively get all MP4 files
function getAllMp4Files($dir, $base_dir = null) {
    if ($base_dir === null) {
        $base_dir = $dir;
    }
    $files = [];
    if (!is_dir($dir)) {
        return $files;
    }
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $files = array_merge($files, getAllMp4Files($path, $base_dir));
        } elseif (strtolower(pathinfo($item, PATHINFO_EXTENSION)) === 'mp4') {
            $files[] = $path;
        }
    }
    return $files;
}

// Get file sizes for all videos (using videoShort as preview/thumbnail)
foreach ($all_videos as &$video) {
    $video['file_size'] = getVideoFileSize($video['videoShort'] ?? '');
    $video['file_size_formatted'] = formatFileSize($video['file_size']);
}

// === VIDEO HEALTH REPORT ===
// Analyze videos for issues
$report = [
    'missing_thumbnails' => [],
    'heavy_videos' => [],
    'missing_credits' => [],
    'missing_video_files' => []
];

$heavy_threshold = 50 * 1024 * 1024; // 50MB threshold for "heavy" videos

foreach ($all_videos as $video) {
    $video_info = [
        'name' => $video['videoName'] . ($video['videoSubName'] ? ' - ' . $video['videoSubName'] : ''),
        'artist' => $video['artist_name'],
        'category' => $video['artist_category']
    ];
    
    // Check for missing thumbnails/posters
    $poster_path = $video['poster'] ?? '';
    if (empty($poster_path)) {
        $report['missing_thumbnails'][] = array_merge($video_info, ['issue' => 'No poster path set']);
    } else {
        $full_poster_path = __DIR__ . '/../' . $poster_path;
        if (!file_exists($full_poster_path)) {
            $report['missing_thumbnails'][] = array_merge($video_info, ['issue' => 'Poster file not found: ' . $poster_path]);
        }
    }
    
    // Check for heavy videos (over threshold)
    if ($video['file_size'] > $heavy_threshold) {
        $report['heavy_videos'][] = array_merge($video_info, [
            'size' => $video['file_size_formatted'],
            'path' => $video['videoShort'] ?? ''
        ]);
    }
    
    // Check for missing credits
    if (empty($video['hasCredit']) || empty($video['credits'])) {
        $report['missing_credits'][] = $video_info;
    }
    
    // Check for missing video files
    $video_path = $video['videoShort'] ?? '';
    if (!empty($video_path)) {
        $full_video_path = __DIR__ . '/../' . $video_path;
        if (!file_exists($full_video_path)) {
            $report['missing_video_files'][] = array_merge($video_info, ['path' => $video_path]);
        }
    }
}

$total_issues = count($report['missing_thumbnails']) + count($report['heavy_videos']) + 
                count($report['missing_credits']) + count($report['missing_video_files']);

// Sort videos by artist name, then by order
usort($all_videos, function($a, $b) {
    $artist_cmp = strcmp($a['artist_name'], $b['artist_name']);
    if ($artist_cmp !== 0) return $artist_cmp;
    return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
});

$total_videos = count($all_videos);

// Calculate total size of ALL MP4 files in roster/videos directories
$video_dirs = [
    __DIR__ . '/../roster/videos',
    __DIR__ . '/../roaster/videos'
];

$total_size = 0;
foreach ($video_dirs as $video_dir) {
    if (is_dir($video_dir)) {
        $mp4_files = getAllMp4Files($video_dir);
        foreach ($mp4_files as $mp4_file) {
            if (file_exists($mp4_file)) {
                $total_size += filesize($mp4_file);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .video-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            border-color: var(--accent);
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            background-color: #000;
            overflow: hidden;
        }

        .video-thumbnail video,
        .video-thumbnail img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-thumbnail .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .video-card:hover .play-overlay {
            opacity: 1;
        }

        .play-overlay i {
            color: #fff;
            font-size: 24px;
            margin-left: 3px;
        }

        .video-info {
            padding: 15px;
        }

        .video-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .video-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .video-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .video-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .video-meta-item i {
            font-size: 10px;
            color: var(--accent);
        }

        .video-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 15px 20px;
            border-radius: 0px;
            flex: 1;
            min-width: 150px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .video-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .video-modal.active {
            display: block;
        }

        .video-modal-content {
            max-width: 90%;
            width: 1200px;
            margin: 20px auto;
            padding: 20px 30px 40px 30px;
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0px;
            position: relative;
        }

        .video-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 24px;
            cursor: pointer;
            padding: 5px 10px;
            transition: color 0.2s ease;
        }

        .video-modal-close:hover {
            color: var(--accent);
        }

        .preview-toggle-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .preview-toggle-btn {
            flex: 1;
            padding: 10px 15px;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 14px;
            border-radius: 0px;
        }
        
        .preview-toggle-btn i {
            margin-right: 5px;
        }
        
        .preview-toggle-btn:hover {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }
        
        .preview-toggle-btn.active {
            background-color: var(--accent);
            color: var(--bg-primary);
            border-color: var(--accent);
        }
        
        .preview-frame-container {
            margin-top: 15px;
        }
        
        .preview-frame {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            background-color: #000;
            border: 2px solid var(--border-color);
            overflow: hidden;
        }
        
        .preview-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .preview-content.active {
            display: flex;
        }
        
        .preview-content video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .preview-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .preview-content > div {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .preview-content > div iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .preview-content > div > div {
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        .preview-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            background-color: #000;
        }
        
        .preview-placeholder i {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.3;
        }
        
        .preview-placeholder p {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        .preview-placeholder small {
            font-size: 12px;
            opacity: 0.7;
            margin-top: 5px;
        }
        
        .quality-control {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding: 12px;
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
        }
        
        .qc-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .qc-item i {
            font-size: 14px;
        }
        
        .qc-item.valid i {
            color: var(--success);
        }
        
        .qc-item.invalid i {
            color: var(--danger);
        }

        .video-modal-info {
            color: var(--text-primary);
        }

        .video-modal-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .video-modal-info p {
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .video-modal-info strong {
            color: var(--text-primary);
        }

        .filter-section {
            margin-bottom: 30px;
        }

        .filter-bar {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 25px;
            border-radius: 0px;
        }

        .filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-controls {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
            align-items: end;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            background-color: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 45px 12px 15px;
            border-radius: 0px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            background-color: var(--bg-secondary);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }

        .filter-select-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-select {
            width: 100%;
            background-color: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 15px;
            border-radius: 0px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            padding-right: 35px;
        }

        .filter-select:hover {
            background-color: var(--bg-hover);
            border-color: var(--accent);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent);
            background-color: var(--bg-secondary);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .filter-controls {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-video"></i> Video Library</h1>
        </div>
        
        <!-- Stats -->
        <div class="video-stats">
            <div class="stat-card">
                <div class="stat-label">Total Videos</div>
                <div class="stat-value"><?php echo $total_videos; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Size (MP4s)</div>
                <div class="stat-value"><?php echo formatFileSize($total_size); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Artists</div>
                <div class="stat-value"><?php echo count($artists); ?></div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <div class="filter-bar">
                <div class="filter-header">
                    <div class="filter-title">
                        <i class="fas fa-filter"></i>
                        <span>Filter & Search</span>
                    </div>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="openHealthReport()" style="margin-left: auto;">
                        <i class="fas fa-clipboard-check"></i> 
                        Health Report
                        <?php if ($total_issues > 0): ?>
                            <span class="badge bg-danger ms-1"><?php echo $total_issues; ?></span>
                        <?php endif; ?>
                    </button>
                </div>
                <div class="filter-controls">
                    <div class="search-container">
                        <input type="text" 
                               id="searchFilter" 
                               class="search-input" 
                               placeholder="Search videos by name, artist, or category..." 
                               onkeyup="filterVideos()">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <div class="filter-select-group">
                        <label class="filter-label">Artist</label>
                        <select id="artistFilter" class="filter-select" onchange="filterVideos()">
                            <option value="">All Artists</option>
                            <?php
                            $unique_artists = array_unique(array_column($all_videos, 'artist_name'));
                            sort($unique_artists);
                            foreach ($unique_artists as $artist_name):
                            ?>
                                <option value="<?php echo htmlspecialchars($artist_name); ?>"><?php echo htmlspecialchars($artist_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-select-group">
                        <label class="filter-label">Category</label>
                        <select id="categoryFilter" class="filter-select" onchange="filterVideos()">
                            <option value="">All Categories</option>
                            <option value="EDIT">Editor</option>
                            <option value="COLOR">Colorist</option>
                            <option value="SOUND">Sound Designer</option>
                            <option value="VFX">VFX Artist</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Grid -->
        <div class="content-card">
            <div class="video-grid" id="videoGrid">
                <?php foreach ($all_videos as $video): 
                    $poster = !empty($video['poster']) ? '../' . $video['poster'] : '';
                    $video_short = !empty($video['videoShort']) ? '../' . $video['videoShort'] : '';
                    $category_label = CATEGORY_LABELS[$video['artist_category']] ?? $video['artist_category'];
                ?>
                    <div class="video-card" 
                         data-artist="<?php echo htmlspecialchars($video['artist_name']); ?>"
                         data-category="<?php echo htmlspecialchars($video['artist_category']); ?>"
                         data-name="<?php echo htmlspecialchars(strtolower($video['videoName'] . ' ' . ($video['videoSubName'] ?? ''))); ?>"
                         data-video-data="<?php echo htmlspecialchars(json_encode($video), ENT_QUOTES); ?>"
                         onclick="openVideoModal(this)">
                        <div class="video-thumbnail">
                            <?php if ($video_short): ?>
                                <!-- Always use video preview (videoShort) as thumbnail -->
                                <video src="<?php echo htmlspecialchars($video_short); ?>" muted loop poster="<?php echo htmlspecialchars($poster); ?>"></video>
                            <?php elseif ($poster): ?>
                                <!-- Fallback to poster image if no video preview -->
                                <img src="<?php echo htmlspecialchars($poster); ?>" alt="<?php echo htmlspecialchars($video['videoName']); ?>">
                            <?php else: ?>
                                <!-- Placeholder if no media -->
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-video" style="font-size: 48px; color: var(--text-muted); opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="play-overlay">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-info">
                            <div class="video-title"><?php echo htmlspecialchars($video['videoName']); ?></div>
                            <?php if (!empty($video['videoSubName'])): ?>
                                <div class="video-subtitle"><?php echo htmlspecialchars($video['videoSubName']); ?></div>
                            <?php endif; ?>
                            <div class="video-meta">
                                <div class="video-meta-item">
                                    <i class="fas fa-user"></i>
                                    <span><?php echo htmlspecialchars($video['artist_name']); ?></span>
                                </div>
                                <div class="video-meta-item">
                                    <i class="fas fa-tag"></i>
                                    <span><?php echo htmlspecialchars($category_label); ?></span>
                                </div>
                                <?php if ($video['file_size'] > 0): ?>
                                    <div class="video-meta-item">
                                        <i class="fas fa-hdd"></i>
                                        <span><?php echo $video['file_size_formatted']; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="video-modal" id="videoModal" onclick="if(event.target === this) closeVideoModal()">
        <div class="video-modal-content" onclick="event.stopPropagation()">
            <button class="video-modal-close" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </button>
            <div id="videoModalContent"></div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterVideos() {
            const artistFilter = document.getElementById('artistFilter').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
            const videoCards = document.querySelectorAll('.video-card');
            
            let visibleCount = 0;
            videoCards.forEach(card => {
                const artist = card.getAttribute('data-artist').toLowerCase();
                const category = card.getAttribute('data-category');
                const name = card.getAttribute('data-name');
                
                const matchesArtist = !artistFilter || artist.includes(artistFilter);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesSearch = !searchFilter || name.includes(searchFilter);
                
                if (matchesArtist && matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function openVideoModal(element) {
            const modal = document.getElementById('videoModal');
            const content = document.getElementById('videoModalContent');
            
            // Get video data from data attribute
            const videoData = element.getAttribute('data-video-data');
            const video = JSON.parse(videoData);
            
            const videoShort = video.videoShort ? '../' + video.videoShort : '';
            const poster = video.poster ? '../' + video.poster : '';
            const categoryLabel = <?php echo json_encode(CATEGORY_LABELS); ?>;
            const categoryLabelText = categoryLabel[video.artist_category] || video.artist_category;
            
            // Build Simian embed HTML
            let videoLongHtml = '';
            let simianUrl = '';
            const videoLongStr = String(video.videoLong || '');
            
            if (videoLongStr) {
                if (videoLongStr.includes('<iframe')) {
                    videoLongHtml = videoLongStr;
                    const urlMatch = videoLongStr.match(/src=["']([^"']+)["']/);
                    if (urlMatch) {
                        simianUrl = urlMatch[1];
                    }
                } else if (videoLongStr.startsWith('http') && videoLongStr.includes('gosimian.com')) {
                    simianUrl = videoLongStr;
                    videoLongHtml = '<div style="width:100%;height:0;position: relative;padding-bottom:56.25%;"><iframe src="' + 
                                   escapeHtml(videoLongStr) + 
                                   '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
                } else if (videoLongStr.startsWith('http')) {
                    simianUrl = videoLongStr;
                    videoLongHtml = '<div style="width:100%;height:0;position: relative;padding-bottom:56.25%;"><iframe src="' + 
                                   escapeHtml(videoLongStr) + 
                                   '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
                }
            }
            
            const hasVideo = videoShort.length > 0;
            const hasFull = videoLongHtml.length > 0;
            const hasThumbnail = poster.length > 0;
            
            content.innerHTML = `
                <h2 style="margin-bottom: 20px; color: var(--text-primary);">
                    <i class="fas fa-edit"></i> Edit Video
                </h2>
                <form method="POST" id="videoEditForm" onsubmit="return saveVideoChanges(event)">
                    <input type="hidden" name="action" value="update_video">
                    <input type="hidden" name="video_id" value="${escapeHtml(video.id || '')}">
                    <input type="hidden" name="artist_id" value="${escapeHtml(video.artist_id || '')}">
                    
                    <div class="mb-3">
                        <label class="form-label">Video Name *</label>
                        <input type="text" class="form-control" name="videoName" value="${escapeHtml(video.videoName || '')}" required oninput="updateVideoPreviewModal()">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Video Subtitle</label>
                        <input type="text" class="form-control" name="videoSubName" value="${escapeHtml(video.videoSubName || '')}" oninput="updateVideoPreviewModal()">
                    </div>
                    
                    <!-- Preview Section -->
                    <div class="mb-4">
                        <h3 class="section-title-small" style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 15px;">
                            <span>Media Preview & Quality Control</span>
                        </h3>
                        <div class="preview-toggle-controls">
                            <button type="button" class="preview-toggle-btn active" data-view="video" onclick="switchVideoPreviewModal('video')">
                                <i class="fas fa-file-video"></i> Video Preview
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="full" onclick="switchVideoPreviewModal('full')">
                                <i class="fas fa-play-circle"></i> Full Video
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="thumbnail" onclick="switchVideoPreviewModal('thumbnail')">
                                <i class="fas fa-image"></i> Image Thumbnail
                            </button>
                        </div>
                        
                        <!-- Preview Frame (16:9) -->
                        <div class="preview-frame-container">
                            <div class="preview-frame" id="modalPreviewFrame">
                                <!-- Video Preview View -->
                                <div class="preview-content active" id="modalPreviewVideo">
                                    ${hasVideo ? 
                                        `<video id="modalPreviewVideoElement" src="${escapeHtml(videoShort)}" muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>` :
                                        `<div class="preview-placeholder">
                                            <i class="fas fa-video"></i>
                                            <p>Video Preview</p>
                                            <small>Set short video path below</small>
                                        </div>`
                                    }
                                </div>
                                
                                <!-- Full Video View -->
                                <div class="preview-content" id="modalPreviewFull">
                                    ${hasFull ? 
                                        `<div id="modalPreviewFullVideo">${videoLongHtml}</div>` :
                                        `<div class="preview-placeholder">
                                            <i class="fas fa-play-circle"></i>
                                            <p>Full Video</p>
                                            <small>Set full video URL below</small>
                                        </div>`
                                    }
                                </div>
                                
                                <!-- Thumbnail View -->
                                <div class="preview-content" id="modalPreviewThumbnail">
                                    ${hasThumbnail ? 
                                        `<img id="modalPreviewThumbnailImg" src="${escapeHtml(poster)}" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">` :
                                        `<div class="preview-placeholder">
                                            <i class="fas fa-image"></i>
                                            <p>Image Thumbnail</p>
                                            <small>Set poster image below</small>
                                        </div>`
                                    }
                                </div>
                            </div>
                            
                            <!-- Quality Control Checkmarks -->
                            <div class="quality-control">
                                <div class="qc-item ${hasVideo ? 'valid' : 'invalid'}" id="modalQcVideo">
                                    <i class="fas ${hasVideo ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                                    <span>Video Preview</span>
                                </div>
                                <div class="qc-item ${hasFull ? 'valid' : 'invalid'}" id="modalQcFull">
                                    <i class="fas ${hasFull ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                                    <span>Full Video</span>
                                </div>
                                <div class="qc-item ${hasThumbnail ? 'valid' : 'invalid'}" id="modalQcThumbnail">
                                    <i class="fas ${hasThumbnail ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                                    <span>Thumbnail</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Short Video (Preview) *</label>
                        <input type="text" class="form-control" name="videoShort" value="${escapeHtml(video.videoShort || '')}" required oninput="updateVideoPreviewModal()">
                        <small class="text-muted">e.g., videos/short/nv1.mp4</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Long Video (Full) *</label>
                        <input type="text" class="form-control" name="videoLong" value="${escapeHtml(video.videoLong || '')}" required oninput="updateVideoPreviewModal()">
                        <small class="text-muted">Full video URL (Simian embed URL or local path)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Poster Image</label>
                        <input type="text" class="form-control" name="poster" value="${escapeHtml(video.poster || '')}" oninput="updateVideoPreviewModal()">
                        <small class="text-muted">Thumbnail/poster image path</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input custom-checkbox" name="hasCredit" id="modalHasCredit" ${video.hasCredit ? 'checked' : ''}>
                            <label class="form-check-label" for="modalHasCredit">Show Credits</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Credits (HTML allowed)</label>
                        <textarea class="form-control" name="credits" rows="4">${escapeHtml(video.credits || '')}</textarea>
                    </div>
                    
                    <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                        <button type="button" class="btn btn-secondary" onclick="closeVideoModal()">Cancel</button>
                    </div>
                </form>
            `;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Auto-play video preview if available and it's the active view
            setTimeout(() => {
                const videoEl = document.getElementById('modalPreviewVideoElement');
                if (videoEl && hasVideo) {
                    // Only play if video preview is the active view
                    const videoPreview = document.getElementById('modalPreviewVideo');
                    if (videoPreview && videoPreview.classList.contains('active')) {
                        videoEl.play().catch(() => {});
                    }
                }
            }, 200);
        }
        
        function switchVideoPreviewModal(view) {
            // Update toggle buttons
            document.querySelectorAll('#videoModalContent .preview-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-view') === view) {
                    btn.classList.add('active');
                }
            });
            
            // Update preview content
            const videoPreview = document.getElementById('modalPreviewVideo');
            const fullPreview = document.getElementById('modalPreviewFull');
            const thumbnailPreview = document.getElementById('modalPreviewThumbnail');
            
            if (videoPreview) videoPreview.classList.remove('active');
            if (fullPreview) fullPreview.classList.remove('active');
            if (thumbnailPreview) thumbnailPreview.classList.remove('active');
            
            // Pause video preview if switching away
            const videoEl = document.getElementById('modalPreviewVideoElement');
            if (videoEl && view !== 'video') {
                videoEl.pause();
            }
            
            if (view === 'video') {
                if (videoPreview) videoPreview.classList.add('active');
                // Play video if available
                if (videoEl && videoEl.src) {
                    setTimeout(() => {
                        videoEl.play().catch(err => {
                            console.log('Video autoplay prevented:', err);
                        });
                    }, 100);
                }
            } else if (view === 'full') {
                if (fullPreview) fullPreview.classList.add('active');
            } else if (view === 'thumbnail') {
                if (thumbnailPreview) thumbnailPreview.classList.add('active');
            }
        }
        
        function updateVideoPreviewModal() {
            const form = document.getElementById('videoEditForm');
            if (!form) return;
            
            const videoShort = form.querySelector('input[name="videoShort"]')?.value || '';
            const videoLong = form.querySelector('input[name="videoLong"]')?.value || '';
            const poster = form.querySelector('input[name="poster"]')?.value || '';
            
            // Update video preview
            const videoContainer = document.getElementById('modalPreviewVideo');
            const videoEl = document.getElementById('modalPreviewVideoElement');
            const videoPlaceholder = videoContainer?.querySelector('.preview-placeholder');
            
            if (videoShort) {
                if (!videoEl) {
                    // Create video element if it doesn't exist
                    if (videoPlaceholder) videoPlaceholder.remove();
                    const newVideo = document.createElement('video');
                    newVideo.id = 'modalPreviewVideoElement';
                    newVideo.src = '../' + videoShort;
                    newVideo.muted = true;
                    newVideo.loop = true;
                    newVideo.playsInline = true;
                    newVideo.style.cssText = 'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;';
                    if (videoContainer) {
                        videoContainer.innerHTML = '';
                        videoContainer.appendChild(newVideo);
                    }
                } else {
                    // Update existing video
                    const currentSrc = videoEl.src;
                    const newSrc = '../' + videoShort;
                    if (currentSrc !== new URL(newSrc, window.location.href).href) {
                        videoEl.src = newSrc;
                        videoEl.load();
                    }
                }
                updateModalQC('video', true);
                
                // Play if video preview is active
                if (videoContainer?.classList.contains('active')) {
                    setTimeout(() => {
                        const el = document.getElementById('modalPreviewVideoElement');
                        if (el) {
                            el.play().catch(err => {
                                console.log('Video autoplay prevented:', err);
                            });
                        }
                    }, 100);
                }
            } else {
                // Remove video, show placeholder
                if (videoEl) videoEl.remove();
                if (videoContainer && !videoPlaceholder) {
                    videoContainer.innerHTML = `
                        <div class="preview-placeholder">
                            <i class="fas fa-video"></i>
                            <p>Video Preview</p>
                            <small>Set short video path below</small>
                        </div>
                    `;
                }
                updateModalQC('video', false);
            }
            
            // Update full video preview
            const fullContainer = document.getElementById('modalPreviewFull');
            const fullVideoDiv = document.getElementById('modalPreviewFullVideo');
            const fullPlaceholder = fullContainer?.querySelector('.preview-placeholder');
            
            if (videoLong) {
                if (fullPlaceholder) fullPlaceholder.remove();
                
                let html = '';
                if (videoLong.includes('gosimian.com') || (videoLong.startsWith('http') && !videoLong.includes('<iframe'))) {
                    html = '<div id="modalPreviewFullVideo" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;"><div style="width:100%;height:0;position: relative;padding-bottom:56.25%;"><iframe src="' + escapeHtml(videoLong) + '" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;border:none;" frameborder="0" allowFullScreen></iframe></div></div>';
                } else if (videoLong.includes('<iframe')) {
                    html = '<div id="modalPreviewFullVideo" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;">' + videoLong + '</div>';
                } else {
                    html = '<div id="modalPreviewFullVideo" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;"><video controls style="width: 100%; height: 100%; object-fit: cover;" src="../' + escapeHtml(videoLong) + '"></video></div>';
                }
                
                if (fullContainer) {
                    if (fullVideoDiv) {
                        fullVideoDiv.outerHTML = html;
                    } else {
                        fullContainer.innerHTML = html;
                    }
                }
                updateModalQC('full', true);
            } else {
                if (fullVideoDiv) fullVideoDiv.remove();
                if (fullContainer && !fullPlaceholder) {
                    fullContainer.innerHTML = `
                        <div class="preview-placeholder">
                            <i class="fas fa-play-circle"></i>
                            <p>Full Video</p>
                            <small>Set full video URL below</small>
                        </div>
                    `;
                }
                updateModalQC('full', false);
            }
            
            // Update thumbnail preview
            const thumbnailContainer = document.getElementById('modalPreviewThumbnail');
            const thumbnailImg = document.getElementById('modalPreviewThumbnailImg');
            const thumbnailPlaceholder = thumbnailContainer?.querySelector('.preview-placeholder');
            
            if (poster) {
                if (thumbnailImg) {
                    thumbnailImg.src = '../' + poster;
                    thumbnailImg.onerror = function() {
                        this.remove();
                        if (thumbnailContainer && !thumbnailPlaceholder) {
                            thumbnailContainer.innerHTML = `
                                <div class="preview-placeholder">
                                    <i class="fas fa-image"></i>
                                    <p>Image Thumbnail</p>
                                    <small>Set poster image below</small>
                                </div>
                            `;
                        }
                        updateModalQC('thumbnail', false);
                    };
                } else {
                    if (thumbnailPlaceholder) thumbnailPlaceholder.remove();
                    const newImg = document.createElement('img');
                    newImg.id = 'modalPreviewThumbnailImg';
                    newImg.src = '../' + poster;
                    newImg.alt = 'Thumbnail';
                    newImg.style.cssText = 'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;';
                    newImg.onerror = function() {
                        this.remove();
                        if (thumbnailContainer) {
                            thumbnailContainer.innerHTML = `
                                <div class="preview-placeholder">
                                    <i class="fas fa-image"></i>
                                    <p>Image Thumbnail</p>
                                    <small>Set poster image below</small>
                                </div>
                            `;
                        }
                        updateModalQC('thumbnail', false);
                    };
                    if (thumbnailContainer) {
                        thumbnailContainer.innerHTML = '';
                        thumbnailContainer.appendChild(newImg);
                    }
                }
                updateModalQC('thumbnail', true);
            } else {
                if (thumbnailImg) thumbnailImg.remove();
                if (thumbnailContainer && !thumbnailPlaceholder) {
                    thumbnailContainer.innerHTML = `
                        <div class="preview-placeholder">
                            <i class="fas fa-image"></i>
                            <p>Image Thumbnail</p>
                            <small>Set poster image below</small>
                        </div>
                    `;
                }
                updateModalQC('thumbnail', false);
            }
        }
        
        function updateModalQC(type, isValid) {
            const qcItem = document.getElementById(`modalQc${type.charAt(0).toUpperCase() + type.slice(1)}`);
            if (qcItem) {
                if (isValid) {
                    qcItem.classList.add('valid');
                    qcItem.classList.remove('invalid');
                    qcItem.querySelector('i').className = 'fas fa-check-circle';
                } else {
                    qcItem.classList.add('invalid');
                    qcItem.classList.remove('valid');
                    qcItem.querySelector('i').className = 'fas fa-times-circle';
                }
            }
        }
        
        function saveVideoChanges(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            
            fetch('videos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Reload page to show updated data
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving video changes. Please try again.');
            });
            
            return false;
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
            
            // Stop any playing videos
            const videos = modal.querySelectorAll('video');
            videos.forEach(video => {
                video.pause();
                video.currentTime = 0;
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }


        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeVideoModal();
            }
        });

        // Auto-play thumbnails on hover (only the MP4 preview)
        document.querySelectorAll('.video-thumbnail video').forEach(video => {
            const card = video.closest('.video-card');
            if (card) {
                card.addEventListener('mouseenter', function() {
                    video.play().catch(() => {}); // Ignore autoplay errors
                });
                card.addEventListener('mouseleave', function() {
                    video.pause();
                    video.currentTime = 0;
                });
            }
        });
    </script>
    
    <!-- Health Report Modal -->
    <div class="modal fade" id="healthReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="background: var(--bg-primary); color: var(--text-primary); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title"><i class="fas fa-clipboard-check text-warning"></i> Video Health Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card text-center h-100" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                                <div class="card-body py-3">
                                    <div class="fs-2 fw-bold <?php echo count($report['missing_thumbnails']) > 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo count($report['missing_thumbnails']); ?>
                                    </div>
                                    <div class="text-muted small">Missing Thumbnails</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center h-100" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                                <div class="card-body py-3">
                                    <div class="fs-2 fw-bold <?php echo count($report['heavy_videos']) > 0 ? 'text-warning' : 'text-success'; ?>">
                                        <?php echo count($report['heavy_videos']); ?>
                                    </div>
                                    <div class="text-muted small">Heavy Videos (>50MB)</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center h-100" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                                <div class="card-body py-3">
                                    <div class="fs-2 fw-bold <?php echo count($report['missing_credits']) > 0 ? 'text-info' : 'text-success'; ?>">
                                        <?php echo count($report['missing_credits']); ?>
                                    </div>
                                    <div class="text-muted small">Missing Credits</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center h-100" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                                <div class="card-body py-3">
                                    <div class="fs-2 fw-bold <?php echo count($report['missing_video_files']) > 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo count($report['missing_video_files']); ?>
                                    </div>
                                    <div class="text-muted small">Missing Video Files</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Accordion for detailed issues -->
                    <div class="accordion" id="healthReportAccordion">
                        
                        <!-- Missing Thumbnails -->
                        <?php if (count($report['missing_thumbnails']) > 0): ?>
                        <div class="accordion-item" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#missingThumbnails" style="background: var(--bg-secondary); color: var(--text-primary);">
                                    <i class="fas fa-image text-danger me-2"></i>
                                    Missing Thumbnails (<?php echo count($report['missing_thumbnails']); ?>)
                                </button>
                            </h2>
                            <div id="missingThumbnails" class="accordion-collapse collapse" data-bs-parent="#healthReportAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Video</th>
                                                    <th>Artist</th>
                                                    <th>Issue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['missing_thumbnails'] as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['artist']); ?></td>
                                                    <td><small class="text-muted"><?php echo htmlspecialchars($item['issue']); ?></small></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Heavy Videos -->
                        <?php if (count($report['heavy_videos']) > 0): ?>
                        <div class="accordion-item" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#heavyVideos" style="background: var(--bg-secondary); color: var(--text-primary);">
                                    <i class="fas fa-weight-hanging text-warning me-2"></i>
                                    Heavy Videos - Over 50MB (<?php echo count($report['heavy_videos']); ?>)
                                </button>
                            </h2>
                            <div id="heavyVideos" class="accordion-collapse collapse" data-bs-parent="#healthReportAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Video</th>
                                                    <th>Artist</th>
                                                    <th>Size</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['heavy_videos'] as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['artist']); ?></td>
                                                    <td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($item['size']); ?></span></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Missing Credits -->
                        <?php if (count($report['missing_credits']) > 0): ?>
                        <div class="accordion-item" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#missingCredits" style="background: var(--bg-secondary); color: var(--text-primary);">
                                    <i class="fas fa-user-tag text-info me-2"></i>
                                    Missing Credits (<?php echo count($report['missing_credits']); ?>)
                                </button>
                            </h2>
                            <div id="missingCredits" class="accordion-collapse collapse" data-bs-parent="#healthReportAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Video</th>
                                                    <th>Artist</th>
                                                    <th>Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['missing_credits'] as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['artist']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['category']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Missing Video Files -->
                        <?php if (count($report['missing_video_files']) > 0): ?>
                        <div class="accordion-item" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#missingVideoFiles" style="background: var(--bg-secondary); color: var(--text-primary);">
                                    <i class="fas fa-film text-danger me-2"></i>
                                    Missing Video Files (<?php echo count($report['missing_video_files']); ?>)
                                </button>
                            </h2>
                            <div id="missingVideoFiles" class="accordion-collapse collapse" data-bs-parent="#healthReportAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Video</th>
                                                    <th>Artist</th>
                                                    <th>Missing Path</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['missing_video_files'] as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['artist']); ?></td>
                                                    <td><small class="text-muted"><?php echo htmlspecialchars($item['path']); ?></small></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($total_issues === 0): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                            <h4 class="text-success">All Videos Are Healthy!</h4>
                            <p class="text-muted">No issues detected with your video library.</p>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openHealthReport() {
            const modal = new bootstrap.Modal(document.getElementById('healthReportModal'));
            modal.show();
        }
    </script>
</body>
</html>
