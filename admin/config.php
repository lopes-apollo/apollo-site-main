<?php
/**
 * Apollo CMS - Configuration
 * Password-protected content management system
 */

// Session management
session_start();

// Database file (JSON-based for simplicity, can be upgraded to SQLite/MySQL later)
define('DATA_DIR', __DIR__ . '/../data/');
define('BACKUP_DIR', DATA_DIR . 'backups/'); // Backup directory for sync versions
define('LANDING_PAGE_FILE', DATA_DIR . 'landing_page.json'); // Featured projects on homepage
define('ARTISTS_FILE', DATA_DIR . 'artists.json'); // Artists with their videos and category tags
define('ROSTER_FILE', DATA_DIR . 'roster.json'); // Roster assignments (which artists appear in which roster sections)
define('SETTINGS_FILE', DATA_DIR . 'settings.json');
define('PENDING_CHANGES_FILE', DATA_DIR . 'pending_changes.json'); // Pending changes waiting for sync
define('CRM_PROJECTS_FILE', DATA_DIR . 'crm_projects.json'); // CRM project management
define('VIDEOS_FILE', DATA_DIR . 'videos.json'); // Centralized video pool
define('ROSTER_FEATURED_FILE', DATA_DIR . 'roster_featured.json'); // Hand-picked videos for roster page
define('CRM_UPLOADS_DIR', __DIR__ . '/../data/crm_uploads/'); // Directory for CRM file uploads

// Admin credentials
// In production, use password_hash() and store in a secure location
define('ADMIN_USERNAME', 'lopes');
// Password hash for 'apollo2026!'
define('ADMIN_PASSWORD_HASH', '$2y$12$b2LMg4B5o3Op5zZYlSjm2uer1GbnlAb9/iKCXm1uc01MjVTRiC4t6'); // Password: apollo2026!

// Create data directory if it doesn't exist
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

// Create backup directory if it doesn't exist
if (!file_exists(BACKUP_DIR)) {
    mkdir(BACKUP_DIR, 0755, true);
}

// Initialize JSON files if they don't exist
function initDataFiles() {
    if (!file_exists(LANDING_PAGE_FILE)) {
        file_put_contents(LANDING_PAGE_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    if (!file_exists(ARTISTS_FILE)) {
        file_put_contents(ARTISTS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    if (!file_exists(ROSTER_FILE)) {
        file_put_contents(ROSTER_FILE, json_encode([
            'EDIT' => [],
            'COLOR' => [],
            'SOUND' => [],
            'VFX' => []
        ], JSON_PRETTY_PRINT));
    }
    if (!file_exists(SETTINGS_FILE)) {
        file_put_contents(SETTINGS_FILE, json_encode([
            'site_title' => 'APOLLO',
            'preloader_video_desktop' => 'home-new/homepreloadervideo.mp4',
            'preloader_video_mobile' => 'home-new/mobilehomepreloadervideo.mp4'
        ], JSON_PRETTY_PRINT));
    }
    if (!file_exists(PENDING_CHANGES_FILE)) {
        file_put_contents(PENDING_CHANGES_FILE, json_encode([
            'landing_page' => null,
            'artists' => null,
            'roster' => null,
            'settings' => null,
            'saved_at' => null
        ], JSON_PRETTY_PRINT));
    }
    if (!file_exists(VIDEOS_FILE)) {
        file_put_contents(VIDEOS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    if (!file_exists(ROSTER_FEATURED_FILE)) {
        file_put_contents(ROSTER_FEATURED_FILE, json_encode([
            'EDIT' => [],
            'COLOR' => [],
            'SOUND' => [],
            'VFX' => []
        ], JSON_PRETTY_PRINT));
    }
    if (!file_exists(CRM_PROJECTS_FILE)) {
        file_put_contents(CRM_PROJECTS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    // Create CRM uploads directory
    if (!file_exists(CRM_UPLOADS_DIR)) {
        mkdir(CRM_UPLOADS_DIR, 0755, true);
        mkdir(CRM_UPLOADS_DIR . 'thumbnails/', 0755, true);
        mkdir(CRM_UPLOADS_DIR . 'videos/', 0755, true);
    }
}

initDataFiles();

// Authentication check
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Static cache for data (cleared on save)
static $cache = [
    'landing_projects' => null,
    'artists' => null,
    'roster' => null,
    'settings' => null,
    'artists_by_id' => null,
    'videos' => null,
    'videos_by_id' => null,
    'roster_featured' => null
];

// Helper functions with caching
function getLandingPageProjects() {
    global $cache;
    if ($cache['landing_projects'] === null) {
        $data = file_get_contents(LANDING_PAGE_FILE);
        $cache['landing_projects'] = json_decode($data, true) ?: [];
    }
    return $cache['landing_projects'];
}

function saveLandingPageProjects($projects) {
    global $cache;
    file_put_contents(LANDING_PAGE_FILE, json_encode($projects, JSON_PRETTY_PRINT));
    $cache['landing_projects'] = $projects; // Update cache
}

function getArtists() {
    global $cache;
    if ($cache['artists'] === null) {
        $data = file_get_contents(ARTISTS_FILE);
        $cache['artists'] = json_decode($data, true) ?: [];
        // Build artists_by_id index for fast lookups
        $cache['artists_by_id'] = [];
        foreach ($cache['artists'] as $artist) {
            $cache['artists_by_id'][$artist['id']] = $artist;
        }
    }
    return $cache['artists'];
}

function saveArtists($artists) {
    global $cache;
    file_put_contents(ARTISTS_FILE, json_encode($artists, JSON_PRETTY_PRINT));
    $cache['artists'] = $artists; // Update cache
    // Rebuild index
    $cache['artists_by_id'] = [];
    foreach ($artists as $artist) {
        $cache['artists_by_id'][$artist['id']] = $artist;
    }
}

// Roster management functions
function getRoster() {
    global $cache;
    if ($cache['roster'] === null) {
        $data = file_get_contents(ROSTER_FILE);
        $cache['roster'] = json_decode($data, true) ?: [
            'EDIT' => [],
            'COLOR' => [],
            'SOUND' => [],
            'VFX' => []
        ];
    }
    return $cache['roster'];
}

function saveRoster($roster) {
    global $cache;
    file_put_contents(ROSTER_FILE, json_encode($roster, JSON_PRETTY_PRINT));
    $cache['roster'] = $roster;
}

function getRosterFeatured() {
    global $cache;
    if ($cache['roster_featured'] === null) {
        $data = file_get_contents(ROSTER_FEATURED_FILE);
        $cache['roster_featured'] = json_decode($data, true) ?: [
            'EDIT' => [], 'COLOR' => [], 'SOUND' => [], 'VFX' => []
        ];
    }
    return $cache['roster_featured'];
}

function saveRosterFeatured($data) {
    global $cache;
    file_put_contents(ROSTER_FEATURED_FILE, json_encode($data, JSON_PRETTY_PRINT));
    $cache['roster_featured'] = $data;
}

// Video Pool functions
function getVideos() {
    global $cache;
    if ($cache['videos'] === null) {
        $data = file_get_contents(VIDEOS_FILE);
        $cache['videos'] = json_decode($data, true) ?: [];
        $cache['videos_by_id'] = [];
        foreach ($cache['videos'] as $video) {
            $cache['videos_by_id'][$video['id']] = $video;
        }
    }
    return $cache['videos'];
}

function getVideoById($id) {
    global $cache;
    if ($cache['videos_by_id'] === null) {
        getVideos();
    }
    return $cache['videos_by_id'][$id] ?? null;
}

function getVideosByIds($ids) {
    $result = [];
    foreach ($ids as $id) {
        $video = getVideoById($id);
        if ($video) {
            $result[] = $video;
        }
    }
    return $result;
}

function saveVideos($videos) {
    global $cache;
    file_put_contents(VIDEOS_FILE, json_encode($videos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    $cache['videos'] = $videos;
    $cache['videos_by_id'] = [];
    foreach ($videos as $video) {
        $cache['videos_by_id'][$video['id']] = $video;
    }
}

function getVideosForArtist($artist) {
    return getVideosByIds($artist['video_ids'] ?? []);
}

function getVideoReferences($video_id) {
    $refs = ['artists' => [], 'landing' => [], 'roster_depts' => [], 'roster_featured_depts' => []];
    $artists = getArtists();
    $roster = getRoster();
    $featured = getRosterFeatured();
    
    // Which artists have this video
    foreach ($artists as $artist) {
        if (in_array($video_id, $artist['video_ids'] ?? [])) {
            $refs['artists'][] = $artist;
        }
    }
    
    // Which roster/department pages show this video (artist is in a roster section)
    $depts_seen = [];
    foreach ($refs['artists'] as $artist) {
        foreach ($roster as $dept => $artist_ids) {
            if (in_array($artist['id'], $artist_ids) && !in_array($dept, $depts_seen)) {
                $depts_seen[] = $dept;
            }
        }
    }
    $refs['roster_depts'] = $depts_seen;
    
    // Roster featured departments using this video
    foreach ($featured as $dept => $vid_ids) {
        if (in_array($video_id, $vid_ids)) {
            $refs['roster_featured_depts'][] = $dept;
        }
    }

    // Landing page projects using this video
    $landing = getLandingPageProjects();
    foreach ($landing as $proj) {
        if (($proj['video_id'] ?? '') === $video_id) {
            $refs['landing'][] = $proj;
        }
    }
    return $refs;
}

function linkVideoToArtist($video_id, $artist_id) {
    $artists = getArtists();
    foreach ($artists as &$artist) {
        if ($artist['id'] === $artist_id) {
            if (!in_array($video_id, $artist['video_ids'] ?? [])) {
                $artist['video_ids'][] = $video_id;
            }
            break;
        }
    }
    unset($artist);
    return $artists;
}

function unlinkVideoFromArtist($video_id, $artist_id) {
    $artists = getArtists();
    foreach ($artists as &$artist) {
        if ($artist['id'] === $artist_id) {
            $artist['video_ids'] = array_values(array_filter($artist['video_ids'] ?? [], fn($id) => $id !== $video_id));
            break;
        }
    }
    unset($artist);
    return $artists;
}

function addVideoToLanding($video_id, $title_override = '', $subtitle_override = '', $author = '') {
    $landing = getLandingPageProjects();
    foreach ($landing as $proj) {
        if (($proj['video_id'] ?? '') === $video_id) {
            return $landing;
        }
    }
    $landing[] = [
        'id' => uniqid('proj_'),
        'video_id' => $video_id,
        'image_class' => 'bgimage' . (count($landing) + 1),
        'title_override' => $title_override,
        'subtitle_override' => $subtitle_override,
        'author' => $author,
        'order' => count($landing),
        'visible' => true
    ];
    return $landing;
}

function removeVideoFromLanding($video_id) {
    $landing = getLandingPageProjects();
    return array_values(array_filter($landing, fn($p) => ($p['video_id'] ?? '') !== $video_id));
}

// Get artists by roster category (OPTIMIZED - uses hash map instead of nested loops)
function getArtistsByRosterCategory($category) {
    global $cache;
    $roster = getRoster();
    $artist_ids = $roster[$category] ?? [];
    
    if (empty($artist_ids)) {
        return [];
    }
    
    // Ensure artists index is built
    if ($cache['artists_by_id'] === null) {
        getArtists(); // This will build the index
    }
    
    // Use hash map lookup instead of nested loops (O(n) instead of O(n*m))
    $result = [];
    foreach ($artist_ids as $artist_id) {
        if (isset($cache['artists_by_id'][$artist_id])) {
            $result[] = $cache['artists_by_id'][$artist_id];
        }
    }
    return $result;
}

// Get artists by category tag (for artist management)
function getArtistsByCategory($category) {
    $artists = getArtists();
    return array_filter($artists, function($artist) use ($category) {
        return ($artist['category'] ?? '') === $category;
    });
}

// Categories (for artist tags)
define('CATEGORIES', ['EDIT', 'COLOR', 'SOUND', 'VFX']);
define('CATEGORY_LABELS', [
    'EDIT' => 'Editor',
    'COLOR' => 'Colorist', 
    'SOUND' => 'Sound Designer',
    'VFX' => 'VFX Artist'
]);

// Roster sections (for website display)
define('ROSTER_SECTIONS', ['EDIT', 'COLOR', 'SOUND', 'VFX']);
define('ROSTER_LABELS', [
    'EDIT' => 'Editors',
    'COLOR' => 'Colorists', 
    'SOUND' => 'Sound Designers',
    'VFX' => 'VFX Artists'
]);

function getSettings() {
    global $cache;
    if ($cache['settings'] === null) {
        $data = file_get_contents(SETTINGS_FILE);
        $cache['settings'] = json_decode($data, true) ?: [];
    }
    return $cache['settings'];
}

function saveSettings($settings) {
    global $cache;
    file_put_contents(SETTINGS_FILE, json_encode($settings, JSON_PRETTY_PRINT));
    $cache['settings'] = $settings; // Update cache
}

// Clear cache (useful for debugging or forced refresh)
function clearCache() {
    global $cache;
    $cache = [
        'landing_projects' => null,
        'artists' => null,
        'roster' => null,
        'settings' => null,
        'artists_by_id' => null,
        'videos' => null,
        'videos_by_id' => null
    ];
}

// Pending Changes Functions (for two-stage save system)
function getPendingChanges() {
    if (!file_exists(PENDING_CHANGES_FILE)) {
        return [
            'landing_page' => null,
            'artists' => null,
            'roster' => null,
            'settings' => null,
            'saved_at' => null
        ];
    }
    $data = file_get_contents(PENDING_CHANGES_FILE);
    return json_decode($data, true) ?: [
        'landing_page' => null,
        'artists' => null,
        'roster' => null,
        'settings' => null,
        'saved_at' => null
    ];
}

function savePendingChanges($changes) {
    $pending = getPendingChanges();
    foreach ($changes as $key => $value) {
        if (in_array($key, ['landing_page', 'artists', 'roster', 'settings'])) {
            $pending[$key] = $value;
        }
    }
    $pending['saved_at'] = date('Y-m-d H:i:s');
    file_put_contents(PENDING_CHANGES_FILE, json_encode($pending, JSON_PRETTY_PRINT));
}

function clearPendingChanges() {
    file_put_contents(PENDING_CHANGES_FILE, json_encode([
        'landing_page' => null,
        'artists' => null,
        'roster' => null,
        'settings' => null,
        'saved_at' => null
    ], JSON_PRETTY_PRINT));
}

function hasPendingChanges() {
    $pending = getPendingChanges();
    return !empty($pending['landing_page']) || 
           !empty($pending['artists']) || 
           !empty($pending['roster']) || 
           !empty($pending['settings']);
}

function applyPendingChanges() {
    $pending = getPendingChanges();
    $applied = [];
    
    if (!empty($pending['landing_page'])) {
        saveLandingPageProjects($pending['landing_page']);
        $applied[] = 'landing_page';
    }
    
    if (!empty($pending['artists'])) {
        saveArtists($pending['artists']);
        $applied[] = 'artists';
    }
    
    if (!empty($pending['roster'])) {
        saveRoster($pending['roster']);
        $applied[] = 'roster';
    }
    
    if (!empty($pending['settings'])) {
        saveSettings($pending['settings']);
        $applied[] = 'settings';
    }
    
    if (!empty($applied)) {
        clearPendingChanges();
        clearCache(); // Clear cache so fresh data is loaded
    }
    
    return $applied;
}

// CRM Project Management Functions
function getCrmProjects() {
    if (!file_exists(CRM_PROJECTS_FILE)) {
        return [];
    }
    $data = file_get_contents(CRM_PROJECTS_FILE);
    return json_decode($data, true) ?: [];
}

function saveCrmProjects($projects) {
    file_put_contents(CRM_PROJECTS_FILE, json_encode($projects, JSON_PRETTY_PRINT));
}

function getCrmProjectById($id) {
    $projects = getCrmProjects();
    foreach ($projects as $project) {
        if ($project['id'] === $id) {
            return $project;
        }
    }
    return null;
}

// Backup and Restore Functions
function createSyncBackup() {
    $timestamp = date('Y-m-d_H-i-s');
    $backup_path = BACKUP_DIR . $timestamp . '/';
    
    if (!file_exists($backup_path)) {
        mkdir($backup_path, 0755, true);
    }
    
    // Backup main index.php
    if (file_exists(__DIR__ . '/../index.php')) {
        copy(__DIR__ . '/../index.php', $backup_path . 'index.php');
    }
    
    // Backup work/index.php
    if (file_exists(__DIR__ . '/../work/index.php')) {
        copy(__DIR__ . '/../work/index.php', $backup_path . 'work_index.php');
    }
    
    // Backup roster/index.php
    if (file_exists(__DIR__ . '/../roster/index.php')) {
        copy(__DIR__ . '/../roster/index.php', $backup_path . 'roster_index.php');
    }
    
    // Backup category pages
    foreach (['edit.php', 'color.php', 'sound.php', 'vfx.php'] as $file) {
        $source = __DIR__ . '/../roster/' . $file;
        if (file_exists($source)) {
            copy($source, $backup_path . $file);
        }
    }
    
    // Backup all artist pages
    $roster_dir = __DIR__ . '/../roster/';
    if (is_dir($roster_dir)) {
        $artist_backup_dir = $backup_path . 'artists/';
        if (!file_exists($artist_backup_dir)) {
            mkdir($artist_backup_dir, 0755, true);
        }
        
        $files = scandir($roster_dir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && 
                $file !== 'index.php' && 
                !in_array($file, ['edit.php', 'color.php', 'sound.php', 'vfx.php'])) {
                $source = $roster_dir . $file;
                $dest = $artist_backup_dir . $file;
                copy($source, $dest);
            }
        }
    }
    
    // Save backup metadata
    $metadata = [
        'timestamp' => $timestamp,
        'date' => date('Y-m-d H:i:s'),
        'files_backed_up' => count(glob($backup_path . '*')) - 1 // Exclude artists directory
    ];
    file_put_contents($backup_path . 'metadata.json', json_encode($metadata, JSON_PRETTY_PRINT));
    
    // Keep only last 3 backups
    cleanupOldBackups();
    
    return $timestamp;
}

function cleanupOldBackups() {
    $backups = getAvailableBackups();
    
    // Sort by timestamp (newest first)
    usort($backups, function($a, $b) {
        return strcmp($b['timestamp'], $a['timestamp']);
    });
    
    // Remove all but the last 3
    if (count($backups) > 3) {
        for ($i = 3; $i < count($backups); $i++) {
            $backup_path = BACKUP_DIR . $backups[$i]['timestamp'] . '/';
            if (is_dir($backup_path)) {
                deleteDirectory($backup_path);
            }
        }
    }
}

function getAvailableBackups() {
    $backups = [];
    
    if (!is_dir(BACKUP_DIR)) {
        return $backups;
    }
    
    $dirs = scandir(BACKUP_DIR);
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') continue;
        
        $backup_path = BACKUP_DIR . $dir . '/';
        if (is_dir($backup_path)) {
            $metadata_file = $backup_path . 'metadata.json';
            if (file_exists($metadata_file)) {
                $metadata = json_decode(file_get_contents($metadata_file), true);
                if ($metadata) {
                    $backups[] = [
                        'timestamp' => $dir,
                        'date' => $metadata['date'] ?? $dir,
                        'files' => $metadata['files_backed_up'] ?? 0
                    ];
                }
            }
        }
    }
    
    // Sort by timestamp (newest first)
    usort($backups, function($a, $b) {
        return strcmp($b['timestamp'], $a['timestamp']);
    });
    
    return $backups;
}

function restoreSyncBackup($timestamp) {
    $backup_path = BACKUP_DIR . $timestamp . '/';
    
    if (!is_dir($backup_path)) {
        return false;
    }
    
    // Restore main index.php
    if (file_exists($backup_path . 'index.php')) {
        copy($backup_path . 'index.php', __DIR__ . '/../index.php');
    }
    
    // PROTECTED: work/index.php is a V2 redirect — do NOT overwrite
    // PROTECTED: roster/index.php is unused by V2 — do NOT overwrite
    
    // Restore category pages
    foreach (['edit.php', 'color.php', 'sound.php', 'vfx.php'] as $file) {
        if (file_exists($backup_path . $file)) {
            copy($backup_path . $file, __DIR__ . '/../roster/' . $file);
        }
    }
    
    // Restore artist pages
    // Restore artist pages from backup, but PROTECT V2 design files
    $v2_protected = ['department.php', 'artist-page.php', 'style-v2.css', 'app-v2.js', 'index.php'];
    $artist_backup_dir = $backup_path . 'artists/';
    if (is_dir($artist_backup_dir)) {
        $files = scandir($artist_backup_dir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && !in_array($file, $v2_protected)) {
                $source = $artist_backup_dir . $file;
                $dest = __DIR__ . '/../roster/' . $file;
                copy($source, $dest);
            }
        }
    }
    
    return true;
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    
    return rmdir($dir);
}
