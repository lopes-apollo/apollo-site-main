<?php
require_once 'config.php';
requireLogin();

$settings = getSettings();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'site_title' => $_POST['site_title'] ?? 'APOLLO',
        'preloader_video_desktop' => $_POST['preloader_video_desktop'] ?? '',
        'preloader_video_mobile' => $_POST['preloader_video_mobile'] ?? '',
    ];
    
    saveSettings($settings);
    $message = '<div class="alert alert-success">Settings saved successfully!</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-cog"></i> Settings</h1>
        </div>
        
        <?php echo $message; ?>
        
        <div class="content-card">
            <h2>Site Settings</h2>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Site Title</label>
                    <input type="text" class="form-control" name="site_title" 
                           value="<?php echo htmlspecialchars($settings['site_title'] ?? 'APOLLO'); ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Preloader Video (Desktop)</label>
                    <input type="text" class="form-control" name="preloader_video_desktop" 
                           value="<?php echo htmlspecialchars($settings['preloader_video_desktop'] ?? 'home-new/homepreloadervideo.mp4'); ?>">
                    <small class="text-muted">Path to desktop preloader video</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Preloader Video (Mobile)</label>
                    <input type="text" class="form-control" name="preloader_video_mobile" 
                           value="<?php echo htmlspecialchars($settings['preloader_video_mobile'] ?? 'home-new/mobilehomepreloadervideo.mp4'); ?>">
                    <small class="text-muted">Path to mobile preloader video</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Settings</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
