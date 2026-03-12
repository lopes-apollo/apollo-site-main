<?php
require_once 'config.php';
requireLogin();

$message = '';
$success = false;
$errors = [];
$pending = getPendingChanges();
$has_pending = hasPendingChanges();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sync'])) {
    // Apply pending changes first (this saves them to the actual data files)
    if ($has_pending) {
        $applied = applyPendingChanges();
        if (!empty($applied)) {
            $message .= '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Applied pending changes: ' . implode(', ', $applied) . '</div>';
            // Clear cache and reload data
            clearCache();
        }
    }
    
    // Create backup before syncing
    $backup_timestamp = createSyncBackup();
    
    if (!function_exists('formatVideoLong')) {
        function formatVideoLong($video_long) {
            if (strpos($video_long, '<iframe') === false && strpos($video_long, 'http') === 0) {
                return '<div style="width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;"><iframe src="' . htmlspecialchars($video_long) . '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
            }
            return $video_long;
        }
    }
    
    $landing_raw = getLandingPageProjects();
    $artists = getArtists();
    $roster = getRoster();
    $settings = getSettings();
    
    // Resolve video_ids for landing page projects (template expects title, video_long, etc.)
    $landing_projects = [];
    foreach ($landing_raw as $proj) {
        $vid = getVideoById($proj['video_id'] ?? '');
        $video_long = '';
        $video_short = '';
        $preview_images = ['','','','','',''];
        $has_credits = false;
        $credits = '';
        if ($vid) {
            $video_long = $vid['videoLong'] ?? '';
            $video_short = $vid['videoShort'] ?? '';
            $preview_images = $vid['previewImages'] ?? ['','','','','',''];
            $has_credits = $vid['hasCredit'] ?? false;
            $credits = $vid['credits'] ?? '';
        }
        $landing_projects[] = [
            'image_class'    => $proj['image_class'] ?? '',
            'title'          => $proj['title_override'] ?? ($vid['title'] ?? ''),
            'subtitle'       => $proj['subtitle_override'] ?? ($vid['subtitle'] ?? ''),
            'author'         => $proj['author'] ?? '',
            'video_long'     => $video_long,
            'video_short'    => $video_short,
            'preview_images' => $preview_images,
            'has_credits'    => $has_credits,
            'credits'        => $credits,
            'order'          => $proj['order'] ?? 999,
            'visible'        => $proj['visible'] ?? true,
        ];
    }
    
    // Resolve video_ids to video objects for all artists (templates expect $artist['videos'])
    foreach ($artists as &$_a) {
        $_a['videos'] = [];
        foreach (getVideosByIds($_a['video_ids'] ?? []) as $v) {
            $_a['videos'][] = [
                'videoName' => $v['title'] ?? '',
                'videoSubName' => $v['subtitle'] ?? '',
                'videoShort' => $v['videoShort'] ?? '',
                'videoLong' => $v['videoLong'] ?? '',
                'poster' => $v['poster'] ?? '',
                'hasCredit' => $v['hasCredit'] ?? false,
                'credits' => $v['credits'] ?? '',
                'previewImages' => $v['previewImages'] ?? ['','','','','',''],
                'order' => $v['order'] ?? 0,
            ];
        }
    }
    unset($_a);
    
    // Generate index.php (landing page)
    ob_start();
    include 'templates/index_template.php';
    $index_content = ob_get_clean();
    
    $index_file = __DIR__ . '/../index.php';
    if (file_put_contents($index_file, $index_content)) {
        $message .= '<div class="alert alert-success">✓ Landing page (index.php) updated</div>';
    } else {
        $errors[] = 'Failed to write index.php';
    }
    
    // PROTECTED: work/index.php is a redirect to the V2 department page.
    // Do NOT regenerate it -- the V2 design (department.php, artist-page.php,
    // style-v2.css, app-v2.js) renders live from JSON data and does not need sync.
    $message .= '<div class="alert alert-info">ℹ work/index.php preserved (V2 redirect)</div>';
    $message .= '<div class="alert alert-info">ℹ roster/index.php skipped (V2 uses department.php)</div>';
    $message .= '<div class="alert alert-info">ℹ Individual artist pages skipped (V2 uses artist-page.php)</div>';
    
    // Generate category pages (edit.php, color.php, sound.php, vfx.php)
    $category_map = [
        'EDIT' => 'edit',
        'COLOR' => 'color',
        'SOUND' => 'sound',
        'VFX' => 'vfx'
    ];
    
    // Build a lookup of resolved artists by ID for category pages
    $artists_by_id_resolved = [];
    foreach ($artists as $a) {
        $artists_by_id_resolved[$a['id']] = $a;
    }
    
    foreach ($category_map as $category => $filename) {
        ob_start();
        $current_category = $category;
        // Build category_artists from resolved artists (with videos populated)
        $roster_ids = $roster[$category] ?? [];
        $category_artists = [];
        foreach ($roster_ids as $aid) {
            if (isset($artists_by_id_resolved[$aid])) {
                $category_artists[] = $artists_by_id_resolved[$aid];
            }
        }
        include 'templates/category_page_template.php';
        $category_content = ob_get_clean();
        
        $category_file = __DIR__ . '/../roster/' . $filename . '.php';
        if (file_put_contents($category_file, $category_content)) {
            $message .= '<div class="alert alert-success">✓ Category page (roster/' . $filename . '.php) updated</div>';
        } else {
            $errors[] = 'Failed to write roster/' . $filename . '.php';
        }
    }
    
    if (empty($errors)) {
        $success = true;
        $message = '<div class="alert alert-success"><h4><i class="fas fa-check-circle"></i> Sync Complete!</h4><p>All website files have been updated successfully. Backup saved: ' . date('Y-m-d H:i:s') . '</p></div>' . $message;
    } else {
        $message = '<div class="alert alert-danger"><h4><i class="fas fa-exclamation-triangle"></i> Sync Completed with Errors</h4><ul><li>' . implode('</li><li>', $errors) . '</li></ul></div>' . $message;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore'])) {
    $restore_timestamp = $_POST['restore_timestamp'] ?? '';
    if ($restore_timestamp && restoreSyncBackup($restore_timestamp)) {
        $message = '<div class="alert alert-success"><h4><i class="fas fa-undo"></i> Restore Complete!</h4><p>Website has been restored to backup from ' . $restore_timestamp . '</p></div>';
    } else {
        $message = '<div class="alert alert-danger"><h4><i class="fas fa-exclamation-triangle"></i> Restore Failed</h4><p>Could not restore backup. Please try again.</p></div>';
    }
}

$landing_projects = getLandingPageProjects();
$artists = getArtists();
$roster = getRoster();
$settings = getSettings();
$available_backups = getAvailableBackups();

// Analyze current website state vs CMS state (using pending if available)
function analyzeWebsiteChanges($use_pending = true) {
    global $pending;
    
    // Use pending changes if available, otherwise use current data
    if ($use_pending && !empty($pending)) {
        $cms_artists = !empty($pending['artists']) ? $pending['artists'] : getArtists();
        $cms_roster = !empty($pending['roster']) ? $pending['roster'] : getRoster();
        $cms_projects = !empty($pending['landing_page']) ? $pending['landing_page'] : getLandingPageProjects();
    } else {
        $cms_artists = getArtists();
        $cms_roster = getRoster();
        $cms_projects = getLandingPageProjects();
    }
    
    $changes = [
        'artists' => [
            'added' => [],
            'removed' => [],
            'modified' => []
        ],
        'videos' => [
            'added' => 0,
            'removed' => 0,
            'modified' => 0
        ],
        'roster' => [
            'changes' => []
        ],
        'projects' => [
            'added' => 0,
            'removed' => 0
        ]
    ];
    
    // Count visible artists and videos in CMS
    $cms_visible_artists = array_filter($cms_artists, function($a) { return $a['visible'] ?? true; });
    $cms_total_videos = 0;
    foreach ($cms_visible_artists as $artist) {
        $cms_total_videos += count($artist['videos'] ?? []);
    }
    
    // Count visible projects in CMS
    $cms_visible_projects = count(array_filter($cms_projects, function($p) { return $p['visible'] ?? true; }));
    
    // Check existing website files
    $existing_artist_files = [];
    $artist_dir = __DIR__ . '/../roster/';
    if (is_dir($artist_dir)) {
        $files = scandir($artist_dir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && $file !== 'index.php' && !in_array($file, ['edit.php', 'color.php', 'sound.php', 'vfx.php'])) {
                $slug = pathinfo($file, PATHINFO_FILENAME);
                $existing_artist_files[] = $slug;
            }
        }
    }
    
    // Find artists that will be added (exist in CMS but not on website)
    foreach ($cms_visible_artists as $artist) {
        if (!empty($artist['slug']) && !in_array($artist['slug'], $existing_artist_files)) {
            $changes['artists']['added'][] = $artist['name'];
        }
    }
    
    // Find artists that will be removed (exist on website but not in CMS)
    foreach ($existing_artist_files as $slug) {
        $found = false;
        foreach ($cms_artists as $artist) {
            if (($artist['slug'] ?? '') === $slug && ($artist['visible'] ?? true)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $changes['artists']['removed'][] = $slug;
        }
    }
    
    // Count roster assignments (using the roster data we have)
    foreach (ROSTER_SECTIONS as $section) {
        $section_artist_ids = $cms_roster[$section] ?? [];
        // Count actual artists (filter out non-existent)
        $section_count = 0;
        foreach ($section_artist_ids as $artist_id) {
            foreach ($cms_artists as $artist) {
                if ($artist['id'] === $artist_id && ($artist['visible'] ?? true)) {
                    $section_count++;
                    break;
                }
            }
        }
        $changes['roster']['changes'][$section] = $section_count;
    }
    
    $changes['videos']['total'] = $cms_total_videos;
    $changes['projects']['total'] = $cms_visible_projects;
    
    return $changes;
}

// Show pending changes in preview if available
$changes = analyzeWebsiteChanges($has_pending);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sync to Website - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-sync"></i> Sync to Website</h1>
        </div>
        
        <?php echo $message; ?>
        
        <!-- Pending Changes Banner -->
        <?php if ($has_pending): ?>
            <div class="content-card mb-3" style="border-left: 4px solid var(--warning);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="color: var(--warning); margin: 0;"><i class="fas fa-exclamation-triangle"></i> Pending Changes Ready to Sync</h4>
                        <p style="margin: 5px 0 0 0; color: var(--text-secondary);">
                            The following changes have been saved and are ready to be synced to the website:
                            <?php
                            $pending_list = [];
                            if (!empty($pending['landing_page'])) $pending_list[] = 'Landing Page';
                            if (!empty($pending['artists'])) $pending_list[] = 'Artists';
                            if (!empty($pending['roster'])) $pending_list[] = 'Roster';
                            if (!empty($pending['settings'])) $pending_list[] = 'Settings';
                            echo implode(', ', $pending_list);
                            ?>
                            <?php if ($pending['saved_at']): ?>
                                <br><small>Saved: <?php echo htmlspecialchars($pending['saved_at']); ?></small>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="content-card mb-3" style="border-left: 4px solid var(--info);">
                <div>
                    <h4 style="color: var(--info); margin: 0;"><i class="fas fa-info-circle"></i> No Pending Changes</h4>
                    <p style="margin: 5px 0 0 0; color: var(--text-secondary);">No pending changes to sync. The website is up to date with the current data.</p>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="content-card">
            <h2>Sync Preview</h2>
            <p class="text-muted mb-4">Review changes before syncing to your website</p>
            
            <div class="sync-comparison">
                <!-- Current Status -->
                <div class="status-section current-status">
                    <div class="status-header">
                        <h3><i class="fas fa-globe"></i> Current Website</h3>
                    </div>
                    <div class="status-content">
                        <div class="status-item">
                            <i class="fas fa-film"></i>
                            <div>
                                <strong>Landing Page</strong>
                                <span class="status-value"><?php echo $changes['projects']['total']; ?> Projects</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <strong>Artists</strong>
                                <span class="status-value"><?php echo count(array_filter($artists, function($a) { return $a['visible'] ?? true; })); ?> Total</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-video"></i>
                            <div>
                                <strong>Videos</strong>
                                <span class="status-value"><?php echo $changes['videos']['total']; ?> Total</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-list"></i>
                            <div>
                                <strong>Roster Sections</strong>
                                <div class="roster-summary">
                                    <?php foreach (ROSTER_SECTIONS as $section): ?>
                                        <span class="roster-badge"><?php echo ROSTER_LABELS[$section]; ?>: <?php echo $changes['roster']['changes'][$section]; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Arrow -->
                <div class="sync-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
                
                <!-- Changes Summary -->
                <div class="status-section changes-summary">
                    <div class="status-header">
                        <h3><i class="fas fa-sync-alt"></i> After Sync</h3>
                    </div>
                    <div class="status-content">
                        <?php 
                        $has_changes = false;
                        if (!empty($changes['artists']['added']) || !empty($changes['artists']['removed'])) {
                            $has_changes = true;
                        }
                        ?>
                        
                        <?php if (!empty($changes['artists']['added'])): ?>
                            <div class="change-item added">
                                <i class="fas fa-plus-circle"></i>
                                <div>
                                    <strong>Adding <?php echo count($changes['artists']['added']); ?> Artist(s)</strong>
                                    <div class="change-details">
                                        <?php foreach (array_slice($changes['artists']['added'], 0, 5) as $name): ?>
                                            <span class="change-badge added-badge"><?php echo htmlspecialchars($name); ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($changes['artists']['added']) > 5): ?>
                                            <span class="change-badge more-badge">+<?php echo count($changes['artists']['added']) - 5; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($changes['artists']['removed'])): ?>
                            <div class="change-item removed">
                                <i class="fas fa-minus-circle"></i>
                                <div>
                                    <strong>Removing <?php echo count($changes['artists']['removed']); ?> Artist(s)</strong>
                                    <div class="change-details">
                                        <?php foreach (array_slice($changes['artists']['removed'], 0, 5) as $slug): ?>
                                            <span class="change-badge removed-badge"><?php echo htmlspecialchars($slug); ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($changes['artists']['removed']) > 5): ?>
                                            <span class="change-badge more-badge">+<?php echo count($changes['artists']['removed']) - 5; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="change-item updated">
                            <i class="fas fa-sync"></i>
                            <div>
                                <strong>Updating All Content</strong>
                                <div class="change-details">
                                    <span class="change-badge info-badge"><?php echo $changes['projects']['total']; ?> Landing Page Projects</span>
                                    <span class="change-badge info-badge"><?php echo count(array_filter($artists, function($a) { return $a['visible'] ?? true; })); ?> Artists</span>
                                    <span class="change-badge info-badge"><?php echo $changes['videos']['total']; ?> Videos</span>
                                    <span class="change-badge info-badge">4 Roster Sections</span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!$has_changes && empty($changes['artists']['added']) && empty($changes['artists']['removed'])): ?>
                            <div class="change-item no-changes">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <strong>No Structural Changes</strong>
                                    <p class="text-muted">All existing artists will be updated with latest content</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="sync-action">
                <form method="POST" onsubmit="return confirm('This will update your website files. Continue?');">
                    <button type="submit" name="sync" class="btn-primary btn-lg btn-sync">
                        <i class="fas fa-sync"></i> Click Sync Now
                    </button>
                </form>
            </div>
        </div>
        
        <?php if (!empty($available_backups)): ?>
        <div class="content-card">
            <h2><i class="fas fa-history"></i> Previous Syncs</h2>
            <p class="text-muted mb-4">Restore to a previous sync if something goes wrong. Only the last 3 syncs are kept.</p>
            
            <div class="backups-list">
                <?php foreach ($available_backups as $backup): ?>
                    <div class="backup-item">
                        <div class="backup-info">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong><?php echo date('F j, Y g:i A', strtotime(str_replace('_', ' ', $backup['timestamp']))); ?></strong>
                                <small class="text-muted"><?php echo $backup['files']; ?> files backed up</small>
                            </div>
                        </div>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('This will restore your website to this backup. Current changes will be lost. Continue?');">
                            <input type="hidden" name="restore_timestamp" value="<?php echo htmlspecialchars($backup['timestamp']); ?>">
                            <button type="submit" name="restore" class="btn-restore">
                                <i class="fas fa-undo"></i> Restore
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="content-card">
            <h2>Website Data Schema Preview</h2>
            <p class="text-muted mb-4">Visual preview of how your website will be structured after syncing</p>
            
            <div class="data-schema-container">
                <!-- Landing Page -->
                <div class="schema-section landing-page-section">
                    <div class="schema-header">
                        <h3><i class="fas fa-home"></i> Landing Page</h3>
                        <span class="schema-count"><?php echo count(array_filter($landing_projects, function($p) { return $p['visible'] ?? true; })); ?> Projects</span>
                    </div>
                    <div class="schema-bubbles">
                        <?php 
                        $visible_projects = array_filter($landing_projects, function($p) { return $p['visible'] ?? true; });
                        foreach (array_slice($visible_projects, 0, 10) as $project): 
                        ?>
                            <div class="schema-bubble project-bubble" title="<?php echo htmlspecialchars($project['title'] ?? 'Untitled'); ?>">
                                <i class="fas fa-film"></i>
                            </div>
                        <?php endforeach; ?>
                        <?php if (count($visible_projects) > 10): ?>
                            <div class="schema-bubble project-bubble more-bubble">
                                +<?php echo count($visible_projects) - 10; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Roster Sections -->
                <div class="schema-section roster-sections">
                    <?php 
                    $roster = getRoster();
                    foreach (ROSTER_SECTIONS as $section): 
                        $section_artists = getArtistsByRosterCategory($section);
                        $section_video_count = 0;
                        foreach ($section_artists as $artist) {
                            $section_video_count += count($artist['videos'] ?? []);
                        }
                    ?>
                        <div class="roster-section-card">
                            <div class="roster-section-header">
                                <h4><?php echo ROSTER_LABELS[$section]; ?></h4>
                                <div class="roster-stats">
                                    <span class="artist-count"><?php echo count($section_artists); ?> Artists</span>
                                    <span class="video-count"><?php echo $section_video_count; ?> Videos</span>
                                </div>
                            </div>
                            
                            <?php if (empty($section_artists)): ?>
                                <div class="empty-roster">
                                    <i class="fas fa-inbox"></i>
                                    <p>No artists assigned</p>
                                </div>
                            <?php else: ?>
                                <div class="artists-container">
                                    <?php foreach ($section_artists as $artist): 
                                        $artist_video_count = count($artist['videos'] ?? []);
                                    ?>
                                        <div class="artist-bubble" title="<?php echo htmlspecialchars($artist['name']); ?>">
                                            <div class="artist-bubble-header">
                                                <i class="fas fa-user"></i>
                                                <span class="artist-name"><?php echo htmlspecialchars($artist['name']); ?></span>
                                            </div>
                                            <div class="artist-videos">
                                                <?php for ($i = 0; $i < min($artist_video_count, 5); $i++): ?>
                                                    <div class="video-dot"></div>
                                                <?php endfor; ?>
                                                <?php if ($artist_video_count > 5): ?>
                                                    <span class="video-count-badge">+<?php echo $artist_video_count - 5; ?></span>
                                                <?php endif; ?>
                                                <span class="video-count-text"><?php echo $artist_video_count; ?> videos</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
