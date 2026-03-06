<?php
require_once 'config.php';
requireLogin();

$landing_projects = getLandingPageProjects();
$artists = getArtists();
$settings = getSettings();

// Calculate stats
$total_videos = 0;
$artists_by_category = [
    'EDIT' => 0,
    'COLOR' => 0,
    'SOUND' => 0,
    'VFX' => 0
];

foreach ($artists as $artist) {
    if ($artist['visible'] ?? true) {
        $videos_count = count($artist['videos'] ?? []);
        $total_videos += $videos_count;
        
        $category = $artist['category'] ?? '';
        if (isset($artists_by_category[$category])) {
            $artists_by_category[$category]++;
        }
    }
}

$visible_projects = count(array_filter($landing_projects, function($p) { return $p['visible'] ?? true; }));
$visible_artists = count(array_filter($artists, function($a) { return $a['visible'] ?? true; }));

// Health Status Checks
$health_checks = [
    'data_files' => [
        'name' => 'Data Files',
        'status' => 'healthy',
        'message' => 'All data files are accessible',
        'icon' => 'fa-database'
    ],
    'artists_content' => [
        'name' => 'Artists Content',
        'status' => 'healthy',
        'message' => 'Artists have videos assigned',
        'icon' => 'fa-users'
    ],
    'landing_page' => [
        'name' => 'Landing Page',
        'status' => 'healthy',
        'message' => 'Landing page has projects',
        'icon' => 'fa-home'
    ],
    'sync_status' => [
        'name' => 'Sync Status',
        'status' => 'healthy',
        'message' => 'Website files are up to date',
        'icon' => 'fa-sync'
    ]
];

// Check data files
if (!file_exists(LANDING_PAGE_FILE) || !file_exists(ARTISTS_FILE) || !file_exists(SETTINGS_FILE)) {
    $health_checks['data_files']['status'] = 'warning';
    $health_checks['data_files']['message'] = 'Some data files are missing';
}

// Check if artists have videos
$artists_without_videos = 0;
foreach ($artists as $artist) {
    if (($artist['visible'] ?? true) && empty($artist['videos'])) {
        $artists_without_videos++;
    }
}

if ($artists_without_videos > 0) {
    $health_checks['artists_content']['status'] = 'warning';
    $health_checks['artists_content']['message'] = $artists_without_videos . ' artist(s) have no videos';
}

if ($visible_artists === 0) {
    $health_checks['artists_content']['status'] = 'error';
    $health_checks['artists_content']['message'] = 'No artists found';
}

// Check landing page
if ($visible_projects === 0) {
    $health_checks['landing_page']['status'] = 'warning';
    $health_checks['landing_page']['message'] = 'No landing page projects';
}

// Check if website files exist (basic sync check)
$index_exists = file_exists(__DIR__ . '/../index.php');
$work_index_exists = file_exists(__DIR__ . '/../work/index.php');
$roster_index_exists = file_exists(__DIR__ . '/../roster/index.php');

if (!$index_exists || !$work_index_exists || !$roster_index_exists) {
    $health_checks['sync_status']['status'] = 'warning';
    $health_checks['sync_status']['message'] = 'Some website files may be missing';
}

// Calculate overall health
$overall_health = 'healthy';
foreach ($health_checks as $check) {
    if ($check['status'] === 'error') {
        $overall_health = 'error';
        break;
    } elseif ($check['status'] === 'warning' && $overall_health === 'healthy') {
        $overall_health = 'warning';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo CMS - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-home"></i> Dashboard</h1>
        </div>
        
        <!-- Website Health Status -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <h2><i class="fas fa-heartbeat"></i> Website Health Status</h2>
                    
                    <div class="health-status-overall" style="margin-bottom: 30px; padding: 20px; background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 48px;">
                                <?php if ($overall_health === 'healthy'): ?>
                                    <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                <?php elseif ($overall_health === 'warning'): ?>
                                    <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                                <?php else: ?>
                                    <i class="fas fa-times-circle" style="color: var(--danger);"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 style="margin: 0 0 5px 0; font-size: 20px; font-weight: 600;">
                                    Overall Status: 
                                    <span style="text-transform: uppercase; 
                                        color: <?php 
                                            echo $overall_health === 'healthy' ? 'var(--success)' : 
                                                ($overall_health === 'warning' ? 'var(--warning)' : 'var(--danger)'); 
                                        ?>;">
                                        <?php echo $overall_health; ?>
                                    </span>
                                </h3>
                                <p style="margin: 0; color: var(--text-secondary); font-size: 13px;">
                                    <?php 
                                    $healthy_count = 0;
                                    foreach ($health_checks as $check) {
                                        if ($check['status'] === 'healthy') $healthy_count++;
                                    }
                                    echo $healthy_count . ' of ' . count($health_checks) . ' checks passing';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?php foreach ($health_checks as $key => $check): ?>
                            <div class="col-md-6 mb-3">
                                <div style="padding: 20px; background: var(--bg-tertiary); border: 1px solid var(--border-color); display: flex; align-items: center; gap: 15px;">
                                    <div style="font-size: 32px;">
                                        <?php if ($check['status'] === 'healthy'): ?>
                                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                        <?php elseif ($check['status'] === 'warning'): ?>
                                            <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle" style="color: var(--danger);"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                            <i class="fas <?php echo $check['icon']; ?>" style="color: var(--text-secondary); font-size: 14px;"></i>
                                            <strong style="color: var(--text-primary); font-size: 14px;"><?php echo $check['name']; ?></strong>
                                        </div>
                                        <p style="margin: 0; color: var(--text-secondary); font-size: 12px;">
                                            <?php echo $check['message']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if ($overall_health !== 'healthy'): ?>
                        <div style="margin-top: 25px; padding: 20px; background: rgba(251, 191, 36, 0.1); border: 1px solid var(--warning);">
                            <p style="margin: 0; color: var(--warning); font-size: 13px;">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Action Required:</strong> Some health checks are not passing. Review the status above and take necessary actions.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card">
                    <h3>Total Artists</h3>
                    <div class="number"><?php echo $visible_artists; ?></div>
                    <small class="text-muted" style="display: block; margin-top: 10px;">
                        <?php echo count($artists); ?> total artists, <?php echo $total_videos; ?> total videos across the website
                    </small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3>Total Videos</h3>
                    <div class="number"><?php echo $total_videos; ?></div>
                    <small class="text-muted" style="display: block; margin-top: 10px;">
                        <?php echo count($artists); ?> total artists, <?php echo $total_videos; ?> total videos across the website
                    </small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3>Categories</h3>
                    <div class="number">4</div>
                    <small class="text-muted" style="display: block; margin-top: 10px;">
                        <?php echo count($artists); ?> total artists, <?php echo $total_videos; ?> total videos across the website
                    </small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <h3>Landing Page</h3>
                    <div class="number"><?php echo count($landing_projects); ?></div>
                    <small class="text-muted" style="display: block; margin-top: 10px;">
                        <?php echo count($landing_projects); ?> total videos
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Category Breakdown -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 20px; padding: 20px;">
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 600; color: var(--text-primary); margin-bottom: 5px;">
                                <?php echo $artists_by_category['EDIT']; ?>
                            </div>
                            <div style="font-size: 14px; color: var(--text-secondary);">Editors</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 600; color: var(--text-primary); margin-bottom: 5px;">
                                <?php echo $artists_by_category['COLOR']; ?>
                            </div>
                            <div style="font-size: 14px; color: var(--text-secondary);">Colorists</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 600; color: var(--text-primary); margin-bottom: 5px;">
                                <?php echo $artists_by_category['SOUND']; ?>
                            </div>
                            <div style="font-size: 14px; color: var(--text-secondary);">Sound Designers</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 600; color: var(--text-primary); margin-bottom: 5px;">
                                <?php echo $artists_by_category['VFX']; ?>
                            </div>
                            <div style="font-size: 14px; color: var(--text-secondary);">VFX Artists</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
