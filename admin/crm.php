<?php
require_once 'config.php';
requireLogin();

$projects = getCrmProjects();
$artists = getArtists();
$landing_projects = getLandingPageProjects();
$message = '';

// Handle GET request for project data (AJAX)
if (isset($_GET['get_project'])) {
    $project = getCrmProjectById($_GET['get_project']);
    if ($project) {
        header('Content-Type: application/json');
        echo json_encode($project);
        exit;
    }
}

// Handle file uploads
function handleFileUpload($file, $type = 'thumbnail') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    $allowed_types = $type === 'video' ? ['video/mp4', 'video/quicktime'] : ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $allowed_extensions = $type === 'video' ? ['mp4', 'mov'] : ['jpg', 'jpeg', 'png', 'gif'];
    
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mime_type = $file['type'];
    
    if (!in_array($mime_type, $allowed_types) || !in_array($file_ext, $allowed_extensions)) {
        return null;
    }
    
    $upload_dir = $type === 'video' ? CRM_UPLOADS_DIR . 'videos/' : CRM_UPLOADS_DIR . 'thumbnails/';
    $filename = uniqid('crm_') . '_' . time() . '.' . $file_ext;
    $target_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return 'data/crm_uploads/' . ($type === 'video' ? 'videos/' : 'thumbnails/') . $filename;
    }
    
    return null;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_project') {
        $project = [
            'id' => uniqid('crm_'),
            'title' => $_POST['title'] ?? 'New Project',
            'project_type' => $_POST['project_type'] ?? 'landing_page', // 'landing_page' or 'artist_video'
            'artist_id' => $_POST['artist_id'] ?? '',
            
            // Landing page fields
            'subtitle' => $_POST['subtitle'] ?? '',
            'author' => $_POST['author'] ?? '',
            'image_class' => $_POST['image_class'] ?? '',
            'video_short' => $_POST['video_short'] ?? '',
            'video_long' => $_POST['video_long'] ?? '',
            'has_credits' => isset($_POST['has_credits']),
            'credits' => $_POST['credits'] ?? '',
            
            // Artist video fields
            'videoName' => $_POST['videoName'] ?? '',
            'videoSubName' => $_POST['videoSubName'] ?? '',
            'videoShort' => $_POST['videoShort'] ?? '',
            'videoLong' => $_POST['videoLong'] ?? '',
            'poster' => $_POST['poster'] ?? '',
            'hasCredit' => isset($_POST['hasCredit']),
            'video_credits' => $_POST['video_credits'] ?? '',
            
            // File uploads
            'thumbnail' => null,
            'video_preview' => null,
            'simian_link' => $_POST['simian_link'] ?? '',
            'notes' => $_POST['notes'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'order' => count($projects),
            'ready_to_publish' => false
        ];
        
        // Handle file uploads
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnail_path = handleFileUpload($_FILES['thumbnail'], 'thumbnail');
            if ($thumbnail_path) {
                $project['thumbnail'] = $thumbnail_path;
            }
        }
        
        if (isset($_FILES['video_preview']) && $_FILES['video_preview']['error'] === UPLOAD_ERR_OK) {
            $video_path = handleFileUpload($_FILES['video_preview'], 'video');
            if ($video_path) {
                $project['video_preview'] = $video_path;
            }
        }
        
        $projects[] = $project;
        saveCrmProjects($projects);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Project added to queue!</div>';
    } elseif ($action === 'update_project') {
        $id = $_POST['id'] ?? '';
        $found = false;
        
        foreach ($projects as $key => $p) {
            if ($p['id'] === $id) {
                $projects[$key]['title'] = $_POST['title'] ?? $p['title'];
                $projects[$key]['project_type'] = $_POST['project_type'] ?? $p['project_type'];
                $projects[$key]['artist_id'] = $_POST['artist_id'] ?? $p['artist_id'];
                
                // Landing page fields
                $projects[$key]['subtitle'] = $_POST['subtitle'] ?? $p['subtitle'] ?? '';
                $projects[$key]['author'] = $_POST['author'] ?? $p['author'] ?? '';
                $projects[$key]['image_class'] = $_POST['image_class'] ?? $p['image_class'] ?? '';
                $projects[$key]['video_short'] = $_POST['video_short'] ?? $p['video_short'] ?? '';
                $projects[$key]['video_long'] = $_POST['video_long'] ?? $p['video_long'] ?? '';
                $projects[$key]['has_credits'] = isset($_POST['has_credits']);
                $projects[$key]['credits'] = $_POST['credits'] ?? $p['credits'] ?? '';
                
                // Artist video fields
                $projects[$key]['videoName'] = $_POST['videoName'] ?? $p['videoName'] ?? '';
                $projects[$key]['videoSubName'] = $_POST['videoSubName'] ?? $p['videoSubName'] ?? '';
                $projects[$key]['videoShort'] = $_POST['videoShort'] ?? $p['videoShort'] ?? '';
                $projects[$key]['videoLong'] = $_POST['videoLong'] ?? $p['videoLong'] ?? '';
                $projects[$key]['poster'] = $_POST['poster'] ?? $p['poster'] ?? '';
                $projects[$key]['hasCredit'] = isset($_POST['hasCredit']);
                $projects[$key]['video_credits'] = $_POST['video_credits'] ?? $p['video_credits'] ?? '';
                
                $projects[$key]['simian_link'] = $_POST['simian_link'] ?? $p['simian_link'] ?? '';
                $projects[$key]['notes'] = $_POST['notes'] ?? $p['notes'] ?? '';
                $projects[$key]['updated_at'] = date('Y-m-d H:i:s');
                
                // Handle file uploads (only if new files are provided)
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                    $thumbnail_path = handleFileUpload($_FILES['thumbnail'], 'thumbnail');
                    if ($thumbnail_path) {
                        if (!empty($p['thumbnail']) && file_exists(__DIR__ . '/../' . $p['thumbnail'])) {
                            @unlink(__DIR__ . '/../' . $p['thumbnail']);
                        }
                        $projects[$key]['thumbnail'] = $thumbnail_path;
                    }
                }
                
                if (isset($_FILES['video_preview']) && $_FILES['video_preview']['error'] === UPLOAD_ERR_OK) {
                    $video_path = handleFileUpload($_FILES['video_preview'], 'video');
                    if ($video_path) {
                        if (!empty($p['video_preview']) && file_exists(__DIR__ . '/../' . $p['video_preview'])) {
                            @unlink(__DIR__ . '/../' . $p['video_preview']);
                        }
                        $projects[$key]['video_preview'] = $video_path;
                    }
                }
                
                $found = true;
                break;
            }
        }
        
        if ($found) {
            saveCrmProjects($projects);
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Project updated!</div>';
        }
    } elseif ($action === 'delete_project') {
        $id = $_POST['id'] ?? '';
        $project_to_delete = null;
        
        foreach ($projects as $key => $p) {
            if ($p['id'] === $id) {
                $project_to_delete = $p;
                unset($projects[$key]);
                break;
            }
        }
        
        if ($project_to_delete) {
            if (!empty($project_to_delete['thumbnail']) && file_exists(__DIR__ . '/../' . $project_to_delete['thumbnail'])) {
                @unlink(__DIR__ . '/../' . $project_to_delete['thumbnail']);
            }
            if (!empty($project_to_delete['video_preview']) && file_exists(__DIR__ . '/../' . $project_to_delete['video_preview'])) {
                @unlink(__DIR__ . '/../' . $project_to_delete['video_preview']);
            }
            
            $projects = array_values($projects);
            saveCrmProjects($projects);
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Project removed!</div>';
        }
    } elseif ($action === 'publish_to_landing') {
        // Publish CRM project to landing page
        $id = $_POST['id'] ?? '';
        $crm_project = getCrmProjectById($id);
        
        if ($crm_project && $crm_project['project_type'] === 'landing_page') {
            $landing_project = [
                'id' => uniqid('proj_'),
                'image_class' => $crm_project['image_class'] ?: 'bgimage' . (count($landing_projects) + 1),
                'title' => $crm_project['title'],
                'subtitle' => $crm_project['subtitle'] ?? '',
                'author' => $crm_project['author'] ?? '',
                'video_short' => $crm_project['video_short'] ?? '',
                'video_long' => $crm_project['video_long'] ?? $crm_project['simian_link'] ?? '',
                'has_credits' => $crm_project['has_credits'] ?? false,
                'credits' => $crm_project['credits'] ?? '',
                'preview_images' => [],
                'order' => count($landing_projects),
                'visible' => true
            ];
            
            $landing_projects[] = $landing_project;
            saveLandingPageProjects($landing_projects);
            
            // Remove from CRM queue
            $projects = array_filter($projects, function($p) use ($id) {
                return $p['id'] !== $id;
            });
            saveCrmProjects(array_values($projects));
            
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Project published to landing page!</div>';
        }
    } elseif ($action === 'publish_to_artist') {
        // Publish CRM project to artist's video list
        $id = $_POST['id'] ?? '';
        $crm_project = getCrmProjectById($id);
        
        if ($crm_project && $crm_project['project_type'] === 'artist_video' && !empty($crm_project['artist_id'])) {
            foreach ($artists as $key => $artist) {
                if ($artist['id'] === $crm_project['artist_id']) {
                    $video = [
                        'id' => uniqid('video_'),
                        'videoName' => $crm_project['videoName'] ?: $crm_project['title'],
                        'videoSubName' => $crm_project['videoSubName'] ?? '',
                        'videoShort' => $crm_project['videoShort'] ?? '',
                        'videoLong' => $crm_project['videoLong'] ?? $crm_project['simian_link'] ?? '',
                        'poster' => $crm_project['poster'] ?? '',
                        'hasCredit' => $crm_project['hasCredit'] ?? false,
                        'credits' => $crm_project['video_credits'] ?? '',
                        'previewImages' => []
                    ];
                    
                    $artists[$key]['videos'][] = $video;
                    saveArtists($artists);
                    
                    // Remove from CRM queue
                    $projects = array_filter($projects, function($p) use ($id) {
                        return $p['id'] !== $id;
                    });
                    saveCrmProjects(array_values($projects));
                    
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Video published to artist!</div>';
                    break;
                }
            }
        }
    } elseif ($action === 'update_order') {
        // Handle drag and drop reordering
        $id = $_POST['id'] ?? '';
        $new_order = intval($_POST['order'] ?? 0);
        
        foreach ($projects as $key => $p) {
            if ($p['id'] === $id) {
                $projects[$key]['order'] = $new_order;
                $projects[$key]['updated_at'] = date('Y-m-d H:i:s');
                break;
            }
        }
        
        saveCrmProjects($projects);
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
    
    $projects = getCrmProjects();
}

// Sort projects by order
usort($projects, function($a, $b) {
    return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Queue - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .project-queue {
            margin-top: 20px;
        }
        
        .queue-item {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0px;
            margin-bottom: 15px;
            cursor: move;
            transition: all 0.2s ease;
        }
        
        .queue-item:hover {
            border-color: var(--accent);
        }
        
        .queue-item.dragging {
            opacity: 0.5;
        }
        
        .queue-item-header {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .queue-item-header:hover {
            background-color: var(--bg-hover);
        }
        
        .queue-item-left {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }
        
        .queue-item-drag-handle {
            color: var(--text-secondary);
            cursor: grab;
            font-size: 18px;
        }
        
        .queue-item-drag-handle:active {
            cursor: grabbing;
        }
        
        .queue-item-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 16px;
        }
        
        .queue-item-meta {
            font-size: 12px;
            color: var(--text-secondary);
            margin-left: 10px;
        }
        
        .queue-item-type-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }
        
        .queue-item-type-badge.landing {
            background-color: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border-color: #3b82f6;
        }
        
        .queue-item-type-badge.artist {
            background-color: rgba(168, 85, 247, 0.2);
            color: #a78bfa;
            border-color: #a855f7;
        }
        
        .queue-item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .queue-item-expand {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 18px;
            padding: 5px 10px;
            transition: transform 0.2s ease;
        }
        
        .queue-item-expand.expanded {
            transform: rotate(180deg);
        }
        
        .queue-item-content {
            display: none;
            padding: 20px;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-primary);
        }
        
        .queue-item-content.expanded {
            display: block;
        }
        
        .file-upload-area {
            border: 2px dashed var(--border-color);
            padding: 20px;
            text-align: center;
            background-color: var(--bg-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 15px;
        }
        
        .file-upload-area:hover {
            border-color: var(--accent);
            background-color: var(--bg-hover);
        }
        
        .file-upload-area.dragover {
            border-color: var(--accent);
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .file-preview {
            margin-top: 10px;
        }
        
        .file-preview img,
        .file-preview video {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid var(--border-color);
        }
        
        .publish-btn {
            background-color: var(--success);
            color: var(--bg-primary);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .publish-btn:hover {
            background-color: #10b981;
        }
        
        .publish-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .queue-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .queue-stat-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 15px 20px;
            border-radius: 0px;
            flex: 1;
            min-width: 150px;
        }
        
        .queue-stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }
        
        .queue-stat-value {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-list"></i> Project Queue</h1>
            <button type="button" class="btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus"></i> Add Project
            </button>
        </div>
        
        <?php echo $message; ?>
        
        <!-- Stats -->
        <div class="queue-stats">
            <div class="queue-stat-card">
                <div class="queue-stat-label">Total in Queue</div>
                <div class="queue-stat-value"><?php echo count($projects); ?></div>
            </div>
            <div class="queue-stat-card">
                <div class="queue-stat-label">Landing Page</div>
                <div class="queue-stat-value"><?php echo count(array_filter($projects, function($p) { return ($p['project_type'] ?? '') === 'landing_page'; })); ?></div>
            </div>
            <div class="queue-stat-card">
                <div class="queue-stat-label">Artist Videos</div>
                <div class="queue-stat-value"><?php echo count(array_filter($projects, function($p) { return ($p['project_type'] ?? '') === 'artist_video'; })); ?></div>
            </div>
        </div>
        
        <!-- Project Queue List -->
        <div class="content-card">
            <div class="project-queue" id="projectQueue">
                <?php if (empty($projects)): ?>
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>No projects in queue. Click "Add Project" to get started.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($projects as $idx => $project): 
                        $artist = null;
                        if (!empty($project['artist_id'])) {
                            foreach ($artists as $a) {
                                if ($a['id'] === $project['artist_id']) {
                                    $artist = $a;
                                    break;
                                }
                            }
                        }
                        $project_type = $project['project_type'] ?? 'landing_page';
                    ?>
                        <div class="queue-item" 
                             draggable="true" 
                             ondragstart="handleDragStart(event)"
                             data-project-id="<?php echo $project['id']; ?>"
                             data-project-index="<?php echo $idx; ?>">
                            <div class="queue-item-header" onclick="toggleProjectExpand(<?php echo $idx; ?>)">
                                <div class="queue-item-left">
                                    <div class="queue-item-drag-handle" onclick="event.stopPropagation()">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                    <div>
                                        <div class="queue-item-title">
                                            <?php echo htmlspecialchars($project['title']); ?>
                                            <span class="queue-item-type-badge <?php echo $project_type === 'landing_page' ? 'landing' : 'artist'; ?>">
                                                <?php echo $project_type === 'landing_page' ? 'Landing Page' : 'Artist Video'; ?>
                                            </span>
                                        </div>
                                        <div class="queue-item-meta">
                                            <?php if ($artist): ?>
                                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($artist['name']); ?>
                                            <?php endif; ?>
                                            <?php if (!empty($project['created_at'])): ?>
                                                <span style="margin-left: 10px;">
                                                    <i class="fas fa-clock"></i> <?php echo date('M d, Y', strtotime($project['created_at'])); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="queue-item-actions">
                                    <button type="button" class="queue-item-expand" onclick="event.stopPropagation(); toggleProjectExpand(<?php echo $idx; ?>)">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="queue-item-content" id="projectContent-<?php echo $idx; ?>">
                                <form method="POST" enctype="multipart/form-data" id="projectForm-<?php echo $idx; ?>">
                                    <input type="hidden" name="action" value="update_project">
                                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Project Type</label>
                                        <select class="form-control" name="project_type" onchange="updateFormType(<?php echo $idx; ?>, this.value)">
                                            <option value="landing_page" <?php echo $project_type === 'landing_page' ? 'selected' : ''; ?>>Landing Page Project</option>
                                            <option value="artist_video" <?php echo $project_type === 'artist_video' ? 'selected' : ''; ?>>Artist Video</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Title *</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                                    </div>
                                    
                                    <!-- Landing Page Fields -->
                                    <div id="landingFields-<?php echo $idx; ?>" style="display: <?php echo $project_type === 'landing_page' ? 'block' : 'none'; ?>;">
                                        <div class="mb-3">
                                            <label class="form-label">Subtitle</label>
                                            <input type="text" class="form-control" name="subtitle" value="<?php echo htmlspecialchars($project['subtitle'] ?? ''); ?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Category/Author *</label>
                                            <select class="form-control" name="author">
                                                <option value="">Select...</option>
                                                <option value="EDIT" <?php echo ($project['author'] ?? '') === 'EDIT' ? 'selected' : ''; ?>>Edit</option>
                                                <option value="COLOR" <?php echo ($project['author'] ?? '') === 'COLOR' ? 'selected' : ''; ?>>Color</option>
                                                <option value="SOUND" <?php echo ($project['author'] ?? '') === 'SOUND' ? 'selected' : ''; ?>>Sound</option>
                                                <option value="VFX" <?php echo ($project['author'] ?? '') === 'VFX' ? 'selected' : ''; ?>>VFX</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Image Class</label>
                                            <input type="text" class="form-control" name="image_class" value="<?php echo htmlspecialchars($project['image_class'] ?? ''); ?>" placeholder="e.g., bgimage8">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Short Video (Preview) *</label>
                                            <input type="text" class="form-control" name="video_short" value="<?php echo htmlspecialchars($project['video_short'] ?? ''); ?>" placeholder="e.g., roster/videos/short/compressed/video.mp4">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Full Video (Simian Link) *</label>
                                            <input type="text" class="form-control" name="video_long" value="<?php echo htmlspecialchars($project['video_long'] ?? ''); ?>" placeholder="https://apollo.gosimian.com/share/v/...">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input custom-checkbox" name="has_credits" id="has_credits_<?php echo $idx; ?>" <?php echo ($project['has_credits'] ?? false) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="has_credits_<?php echo $idx; ?>">Show Credits</label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Credits (HTML allowed)</label>
                                            <textarea class="form-control" name="credits" rows="4"><?php echo htmlspecialchars($project['credits'] ?? ''); ?></textarea>
                                        </div>
                                        
                                        <div class="form-actions">
                                            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Publish this project to the landing page?');">
                                                <input type="hidden" name="action" value="publish_to_landing">
                                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                                <button type="submit" class="publish-btn"><i class="fas fa-upload"></i> Publish to Landing Page</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Artist Video Fields -->
                                    <div id="artistFields-<?php echo $idx; ?>" style="display: <?php echo $project_type === 'artist_video' ? 'block' : 'none'; ?>;">
                                        <div class="mb-3">
                                            <label class="form-label">Artist *</label>
                                            <select class="form-control" name="artist_id" required>
                                                <option value="">Select Artist...</option>
                                                <?php foreach ($artists as $artist): ?>
                                                    <option value="<?php echo htmlspecialchars($artist['id']); ?>" <?php echo ($project['artist_id'] ?? '') === $artist['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($artist['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Video Name *</label>
                                            <input type="text" class="form-control" name="videoName" value="<?php echo htmlspecialchars($project['videoName'] ?? $project['title']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Video Subtitle</label>
                                            <input type="text" class="form-control" name="videoSubName" value="<?php echo htmlspecialchars($project['videoSubName'] ?? ''); ?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Short Video (Preview) *</label>
                                            <input type="text" class="form-control" name="videoShort" value="<?php echo htmlspecialchars($project['videoShort'] ?? ''); ?>" placeholder="e.g., videos/short/nv1.mp4">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Full Video (Simian Link) *</label>
                                            <input type="text" class="form-control" name="videoLong" value="<?php echo htmlspecialchars($project['videoLong'] ?? ''); ?>" placeholder="https://apollo.gosimian.com/share/v/...">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Poster Image</label>
                                            <input type="text" class="form-control" name="poster" value="<?php echo htmlspecialchars($project['poster'] ?? ''); ?>" placeholder="Path to poster image">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input custom-checkbox" name="hasCredit" id="hasCredit_<?php echo $idx; ?>" <?php echo ($project['hasCredit'] ?? false) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="hasCredit_<?php echo $idx; ?>">Show Credits</label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Credits (HTML allowed)</label>
                                            <textarea class="form-control" name="video_credits" rows="4"><?php echo htmlspecialchars($project['video_credits'] ?? ''); ?></textarea>
                                        </div>
                                        
                                        <div class="form-actions">
                                            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Publish this video to the artist?');">
                                                <input type="hidden" name="action" value="publish_to_artist">
                                                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                                <button type="submit" class="publish-btn"><i class="fas fa-upload"></i> Publish to Artist</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Common Fields -->
                                    <hr style="margin: 20px 0;">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Simian Embed Link (Alternative)</label>
                                        <input type="text" class="form-control" name="simian_link" value="<?php echo htmlspecialchars($project['simian_link'] ?? ''); ?>" placeholder="https://apollo.gosimian.com/share/v/...">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Thumbnail Image</label>
                                        <?php if (!empty($project['thumbnail'])): ?>
                                            <div class="file-preview mb-2">
                                                <img src="../<?php echo htmlspecialchars($project['thumbnail']); ?>" style="max-width: 200px;">
                                            </div>
                                        <?php endif; ?>
                                        <div class="file-upload-area" onclick="document.getElementById('thumbnailInput_<?php echo $idx; ?>').click()">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                                            <p>Click to upload or drag and drop</p>
                                            <small class="text-muted">JPG, PNG, GIF</small>
                                        </div>
                                        <input type="file" id="thumbnailInput_<?php echo $idx; ?>" name="thumbnail" accept="image/*" style="display: none;" onchange="previewFile(this, 'thumbnailPreview_<?php echo $idx; ?>', 'image')">
                                        <div class="file-preview" id="thumbnailPreview_<?php echo $idx; ?>"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Video Preview</label>
                                        <?php if (!empty($project['video_preview'])): ?>
                                            <div class="file-preview mb-2">
                                                <video src="../<?php echo htmlspecialchars($project['video_preview']); ?>" controls style="max-width: 200px;"></video>
                                            </div>
                                        <?php endif; ?>
                                        <div class="file-upload-area" onclick="document.getElementById('videoInput_<?php echo $idx; ?>').click()">
                                            <i class="fas fa-video" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                                            <p>Click to upload or drag and drop</p>
                                            <small class="text-muted">MP4, MOV</small>
                                        </div>
                                        <input type="file" id="videoInput_<?php echo $idx; ?>" name="video_preview" accept="video/*" style="display: none;" onchange="previewFile(this, 'videoPreview_<?php echo $idx; ?>', 'video')">
                                        <div class="file-preview" id="videoPreview_<?php echo $idx; ?>"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="Internal notes, reminders..."><?php echo htmlspecialchars($project['notes'] ?? ''); ?></textarea>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                                        <button type="button" class="btn btn-danger" onclick="deleteProject('<?php echo $project['id']; ?>')">
                                            <i class="fas fa-trash"></i> Remove from Queue
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Create Modal -->
    <div class="crm-modal" id="createModal" onclick="if(event.target === this) closeCreateModal()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.95); z-index: 10000; overflow-y: auto; align-items: center; justify-content: center;">
        <div class="crm-modal-content" onclick="event.stopPropagation()" style="max-width: 600px; width: 90%; max-height: 90vh; margin: 20px auto; background-color: var(--bg-primary); border: 1px solid var(--border-color); padding: 30px; border-radius: 0px; position: relative; overflow-y: auto;">
            <button class="crm-modal-close" onclick="closeCreateModal()" style="position: absolute; top: 15px; right: 15px; background: none; border: none; color: var(--text-primary); font-size: 24px; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
            <h2><i class="fas fa-plus"></i> Add New Project</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create_project">
                
                <div class="mb-3">
                    <label class="form-label">Project Type</label>
                    <select class="form-control" name="project_type" id="newProjectType" onchange="updateNewFormType(this.value)">
                        <option value="landing_page">Landing Page Project</option>
                        <option value="artist_video">Artist Video</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                
                <div class="mb-3" id="newArtistSelect" style="display: none;">
                    <label class="form-label">Artist</label>
                    <select class="form-control" name="artist_id">
                        <option value="">Select Artist...</option>
                        <?php foreach ($artists as $artist): ?>
                            <option value="<?php echo htmlspecialchars($artist['id']); ?>">
                                <?php echo htmlspecialchars($artist['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Add to Queue</button>
                    <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let draggedElement = null;
        
        function toggleProjectExpand(index) {
            const content = document.getElementById('projectContent-' + index);
            const expandBtn = document.querySelector(`[data-project-index="${index}"] .queue-item-expand`);
            
            if (content.classList.contains('expanded')) {
                content.classList.remove('expanded');
                expandBtn.classList.remove('expanded');
            } else {
                // Close all others
                document.querySelectorAll('.queue-item-content').forEach(c => c.classList.remove('expanded'));
                document.querySelectorAll('.queue-item-expand').forEach(b => b.classList.remove('expanded'));
                
                content.classList.add('expanded');
                expandBtn.classList.add('expanded');
            }
        }
        
        function updateFormType(index, type) {
            const landingFields = document.getElementById('landingFields-' + index);
            const artistFields = document.getElementById('artistFields-' + index);
            
            if (type === 'landing_page') {
                landingFields.style.display = 'block';
                artistFields.style.display = 'none';
            } else {
                landingFields.style.display = 'none';
                artistFields.style.display = 'block';
            }
        }
        
        function updateNewFormType(type) {
            const artistSelect = document.getElementById('newArtistSelect');
            if (type === 'artist_video') {
                artistSelect.style.display = 'block';
                artistSelect.querySelector('select').required = true;
            } else {
                artistSelect.style.display = 'none';
                artistSelect.querySelector('select').required = false;
            }
        }
        
        function previewFile(input, previewId, type) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (type === 'image') {
                        preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100%; max-height: 200px; border: 1px solid var(--border-color);">';
                    } else {
                        preview.innerHTML = '<video src="' + e.target.result + '" controls style="max-width: 100%; max-height: 200px; border: 1px solid var(--border-color);"></video>';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function deleteProject(id) {
            if (confirm('Remove this project from the queue?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_project">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.style.display = 'flex';
            // Ensure modal is centered and scrollable
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            // Scroll to top of modal
            setTimeout(() => {
                modal.scrollTop = 0;
            }, 10);
        }
        
        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }
        
        // Drag and Drop
        function handleDragStart(e) {
            draggedElement = e.currentTarget;
            e.currentTarget.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const queue = document.getElementById('projectQueue');
            
            queue.addEventListener('dragover', function(e) {
                e.preventDefault();
                const afterElement = getDragAfterElement(queue, e.clientY);
                const dragging = document.querySelector('.dragging');
                if (afterElement == null) {
                    queue.appendChild(dragging);
                } else {
                    queue.insertBefore(dragging, afterElement);
                }
            });
            
            queue.addEventListener('drop', function(e) {
                e.preventDefault();
                if (draggedElement) {
                    const projectId = draggedElement.getAttribute('data-project-id');
                    const items = queue.querySelectorAll('.queue-item');
                    const newOrder = Array.from(items).indexOf(draggedElement);
                    
                    // Update order via AJAX
                    fetch('crm.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=update_order&id=${projectId}&order=${newOrder}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
                    
                    draggedElement.classList.remove('dragging');
                    draggedElement = null;
                }
            });
        });
        
        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.queue-item:not(.dragging)')];
            
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    </script>
</body>
</html>
