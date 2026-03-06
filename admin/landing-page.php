<?php
require_once 'config.php';
requireLogin();

$projects = getLandingPageProjects();
$pending = getPendingChanges();
$pending_projects = $pending['landing_page'] ?? null;
$has_pending = !empty($pending_projects);
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'save') {
        $id = $_POST['id'] ?? uniqid('proj_');
        $project = [
            'id' => $id,
            'image_class' => $_POST['image_class'] ?? 'bgimage' . (count($projects) + 1),
            'title' => $_POST['title'] ?? '',
            'subtitle' => $_POST['subtitle'] ?? '',
            'author' => $_POST['author'] ?? '',
            'video_short' => $_POST['video_short'] ?? '',
            'video_long' => $_POST['video_long'] ?? '',
            'has_credits' => isset($_POST['has_credits']),
            'credits' => $_POST['credits'] ?? '',
            'preview_images' => [
                '', '', '', '', '', '' // Preview images removed from UI - kept for backward compatibility
            ],
            'order' => intval($_POST['order'] ?? count($projects)),
            'visible' => isset($_POST['visible'])
        ];
        
        // Update or add to current projects (for display)
        $found = false;
        foreach ($projects as $key => $p) {
            if ($p['id'] === $id) {
                $projects[$key] = $project;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $projects[] = $project;
        }
        
        // Sort by order
        usort($projects, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        // Save to pending changes instead of directly
        savePendingChanges(['landing_page' => $projects]);
        $message = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Changes saved to pending!</strong> Click "Save to Next Sync" below to prepare these changes for the next website sync.</div>';
        $pending_projects = $projects;
        $has_pending = true;
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $projects = array_filter($projects, function($p) use ($id) {
            return $p['id'] !== $id;
        });
        $projects = array_values($projects);
        
        // Save to pending changes
        savePendingChanges(['landing_page' => $projects]);
        $message = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Deletion saved to pending!</strong> Click "Save to Next Sync" below to prepare this change for the next website sync.</div>';
        $pending_projects = $projects;
        $has_pending = true;
    } elseif ($action === 'save_to_sync') {
        // This just confirms - actual save already happened above
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Changes saved for next sync!</strong> Go to <a href="sync.php">Sync to Website</a> to apply these changes.</div>';
    }
    
    // Refresh data
    $projects = getLandingPageProjects();
    $pending = getPendingChanges();
    $pending_projects = $pending['landing_page'] ?? null;
    $has_pending = !empty($pending_projects);
}

$editing = null;
if (isset($_GET['edit'])) {
    foreach ($projects as $p) {
        if ($p['id'] === $_GET['edit']) {
            $editing = $p;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Compact Status Box */
        .status-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 0px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid;
        }
        
        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            border-color: var(--warning);
            color: var(--warning);
        }
        
        .status-synced {
            background-color: rgba(74, 222, 128, 0.1);
            border-color: var(--success);
            color: var(--success);
        }
        
        .status-box i {
            font-size: 14px;
        }
        
        .status-btn {
            background-color: var(--warning);
            border: none;
            color: var(--bg-primary);
            padding: 4px 12px;
            font-size: 12px;
            cursor: pointer;
            border-radius: 0px;
            transition: background-color 0.2s ease;
        }
        
        .status-btn:hover {
            background-color: #e6a200;
        }
        
        .status-btn i {
            margin-right: 4px;
        }
        .project-form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .project-form-section:last-child {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .toggle-section {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.3s ease;
        }
        
        .toggle-section.active {
            transform: rotate(180deg);
        }
        
        .section-content {
            transition: all 0.3s ease;
        }
        
        /* Preview Toggle Controls */
        .preview-toggle-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .preview-toggle-btn {
            flex: 1;
            padding: 12px 20px;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 14px;
            border-radius: 0px;
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
        
        /* Preview Frame (16:9) */
        .preview-frame-container {
            margin-top: 20px;
        }
        
        .preview-frame {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            background-color: #000;
            border: 2px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 15px;
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
        
        .preview-placeholder {
            text-align: center;
            color: var(--text-muted);
        }
        
        .preview-placeholder i {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }
        
        .preview-placeholder p {
            margin: 10px 0 5px 0;
            font-size: 16px;
        }
        
        .preview-placeholder small {
            font-size: 12px;
        }
        
        /* Quality Control */
        .quality-control {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 15px;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
        }
        
        .qc-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 14px;
        }
        
        .qc-item i {
            font-size: 18px;
        }
        
        .qc-item.valid i {
            color: var(--success);
        }
        
        .qc-item.invalid i {
            color: var(--danger);
        }
        
        .qc-item.valid {
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-home"></i> Landing Page Projects</h1>
            <a href="?action=add" class="btn-primary"><i class="fas fa-plus"></i> Add Project</a>
        </div>
        
        <!-- Compact Status Box -->
        <?php if ($has_pending): ?>
            <div class="status-box status-pending">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Changes Pending</span>
                <form method="POST" style="display: inline; margin-left: 10px;">
                    <input type="hidden" name="action" value="save_to_sync">
                    <button type="submit" class="status-btn">
                        <i class="fas fa-save"></i> Save to Sync
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="status-box status-synced">
                <i class="fas fa-check-circle"></i>
                <span>All Synced</span>
            </div>
        <?php endif; ?>
        
        <div class="content-card mb-3">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Landing Page Projects</strong> are featured projects that appear on your homepage. 
                These are separate from artist videos. Manage artists and their videos in the <a href="artists.php">Artists</a> section.
            </div>
        </div>
        
        <?php echo $message; ?>
        
        <?php if ($editing || isset($_GET['action']) && $_GET['action'] === 'add'): ?>
            <!-- Edit/Add Form -->
            <div class="content-card">
                <h2><?php echo $editing ? 'Edit Project' : 'Add New Project'; ?></h2>
                <form method="POST" id="projectForm">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo $editing['id'] ?? ''; ?>">
                    
                    <!-- Basic Info Section -->
                    <div class="project-form-section">
                        <h3 class="section-title">Basic Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title *</label>
                                    <input type="text" class="form-control" name="title" 
                                           value="<?php echo htmlspecialchars($editing['title'] ?? ''); ?>" 
                                           required oninput="updatePreview()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle" 
                                           value="<?php echo htmlspecialchars($editing['subtitle'] ?? ''); ?>"
                                           oninput="updatePreview()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Category *</label>
                                    <select class="form-control" name="author" required>
                                        <option value="">Select...</option>
                                        <option value="EDIT" <?php echo ($editing['author'] ?? '') === 'EDIT' ? 'selected' : ''; ?>>Edit</option>
                                        <option value="COLOR" <?php echo ($editing['author'] ?? '') === 'COLOR' ? 'selected' : ''; ?>>Color</option>
                                        <option value="SOUND" <?php echo ($editing['author'] ?? '') === 'SOUND' ? 'selected' : ''; ?>>Sound</option>
                                        <option value="VFX" <?php echo ($editing['author'] ?? '') === 'VFX' ? 'selected' : ''; ?>>VFX</option>
                                        <option value="EDIT,SOUND" <?php echo ($editing['author'] ?? '') === 'EDIT,SOUND' ? 'selected' : ''; ?>>Edit + Sound</option>
                                        <option value="EDIT,SOUND,VFX" <?php echo ($editing['author'] ?? '') === 'EDIT,SOUND,VFX' ? 'selected' : ''; ?>>Edit + Sound + VFX</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Visual Preview Section -->
                    <div class="project-form-section">
                        <h3 class="section-title">Visual Preview & Quality Control</h3>
                        
                        <!-- Preview Toggle Buttons -->
                        <div class="preview-toggle-controls">
                            <button type="button" class="preview-toggle-btn active" data-view="video" onclick="switchPreview('video')">
                                <i class="fas fa-video"></i> Video Preview
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="full" onclick="switchPreview('full')">
                                <i class="fas fa-play-circle"></i> Full Video
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="thumbnail" onclick="switchPreview('thumbnail')">
                                <i class="fas fa-image"></i> Image Thumbnail
                            </button>
                        </div>
                        
                        <!-- Preview Frame (16:9) -->
                        <div class="preview-frame-container">
                            <div class="preview-frame" id="previewFrame">
                                <!-- Video Preview View -->
                                <div class="preview-content active" id="previewVideo">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-video"></i>
                                        <p>Video Preview</p>
                                        <small>Set short video path below</small>
                                    </div>
                                    <video id="previewVideoElement" src="" muted loop playsinline style="display: none; width: 100%; height: 100%; object-fit: cover;"></video>
                                </div>
                                
                                <!-- Full Video View -->
                                <div class="preview-content" id="previewFull">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-play-circle"></i>
                                        <p>Full Video</p>
                                        <small>Set full video URL below</small>
                                    </div>
                                    <div id="previewFullVideo" style="display: none; width: 100%; height: 100%;"></div>
                                </div>
                                
                                <!-- Thumbnail View -->
                                <div class="preview-content" id="previewThumbnail">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-image"></i>
                                        <p>Image Thumbnail</p>
                                        <small>Set image class or preview images below</small>
                                    </div>
                                    <img id="previewThumbnailImg" src="" alt="Thumbnail" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                            
                            <!-- Quality Control Checkmarks -->
                            <div class="quality-control">
                                <div class="qc-item" id="qcVideo">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Video Preview</span>
                                </div>
                                <div class="qc-item" id="qcFull">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Full Video</span>
                                </div>
                                <div class="qc-item" id="qcThumbnail">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Thumbnail</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Media URLs Section (Collapsible) -->
                    <div class="project-form-section">
                        <h3 class="section-title">
                            <span>Media URLs</span>
                            <button type="button" class="toggle-section" onclick="toggleSection(this)">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h3>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image Class</label>
                                        <input type="text" class="form-control" name="image_class" 
                                               value="<?php echo htmlspecialchars($editing['image_class'] ?? 'bgimage' . (count($projects) + 1)); ?>"
                                               oninput="updatePreview()">
                                        <small class="text-muted">CSS class for background image (e.g., bgimage8)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Short Video (Preview) *</label>
                                        <input type="text" class="form-control" name="video_short" 
                                               value="<?php echo htmlspecialchars($editing['video_short'] ?? ''); ?>" 
                                               required oninput="updatePreview()">
                                        <small class="text-muted">Path to short video (e.g., roster/videos/short/compressed/trexx cover-1080p.mp4)</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Long Video (Full) *</label>
                                <input type="text" class="form-control" name="video_long" 
                                       value="<?php echo htmlspecialchars($editing['video_long'] ?? ''); ?>" 
                                       required oninput="updatePreview()">
                                <small class="text-muted">Full video URL (Simian embed URL or local path)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Settings (Collapsible) -->
                    <div class="project-form-section">
                        <h3 class="section-title">
                            <span>Additional Settings</span>
                            <button type="button" class="toggle-section" onclick="toggleSection(this)">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h3>
                        <div class="section-content" style="display: none;">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="has_credits" id="has_credits" 
                                           <?php echo ($editing['has_credits'] ?? false) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="has_credits">Show Credits</label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Credits (HTML allowed)</label>
                                <textarea class="form-control" name="credits" rows="6"><?php echo htmlspecialchars($editing['credits'] ?? ''); ?></textarea>
                                <small class="text-muted">Use HTML tags like &lt;h3&gt;, &lt;br&gt; for formatting</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" class="form-control" name="order" 
                                               value="<?php echo $editing['order'] ?? count($projects); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" class="form-check-input" name="visible" id="visible" 
                                                   <?php echo ($editing['visible'] ?? true) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="visible">Visible on Website</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                        <a href="landing-page.php" class="btn btn-secondary">Cancel</a>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Changes will be saved to pending. Use "Save to Next Sync" above to prepare for sync.
                        </small>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- Projects List -->
            <div class="content-card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Visible</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($projects)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No projects yet. <a href="?action=add">Add your first project</a></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?php echo $project['order']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($project['title']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($project['subtitle']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($project['author']); ?></td>
                                    <td>
                                        <?php if ($project['visible'] ?? true): ?>
                                            <span class="badge bg-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this project?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchPreview(view) {
            // Update toggle buttons
            document.querySelectorAll('.preview-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-view') === view) {
                    btn.classList.add('active');
                }
            });
            
            // Update preview content
            document.querySelectorAll('.preview-content').forEach(content => {
                content.classList.remove('active');
            });
            
            if (view === 'thumbnail') {
                document.getElementById('previewThumbnail').classList.add('active');
            } else if (view === 'video') {
                document.getElementById('previewVideo').classList.add('active');
                // Try to play video
                const videoEl = document.getElementById('previewVideoElement');
                if (videoEl.src) {
                    videoEl.play().catch(() => {});
                }
            } else if (view === 'full') {
                document.getElementById('previewFull').classList.add('active');
            }
        }
        
        function updatePreview() {
            const form = document.getElementById('projectForm');
            const formData = new FormData(form);
            
            // Get values
            const imageClass = formData.get('image_class') || '';
            const videoShort = formData.get('video_short') || '';
            const videoLong = formData.get('video_long') || '';
            const prev1 = formData.get('prev1') || '';
            
            // Update thumbnail preview - use image class (background image)
            const thumbnailImg = document.getElementById('previewThumbnailImg');
            const thumbnailPlaceholder = document.querySelector('#previewThumbnail .preview-placeholder');
            
            // For thumbnail, we show the image class background (if available)
            // Since preview images are removed, we'll just show a placeholder
            // The actual thumbnail on the website uses the background image class
            if (imageClass) {
                thumbnailPlaceholder.innerHTML = '<i class="fas fa-image"></i><p>Image Class: ' + imageClass + '</p><small>Thumbnail uses background image class</small>';
                thumbnailPlaceholder.style.display = 'flex';
                thumbnailImg.style.display = 'none';
                updateQC('thumbnail', true);
            } else {
                thumbnailPlaceholder.innerHTML = '<i class="fas fa-image"></i><p>Image Thumbnail</p><small>Set image class below</small>';
                thumbnailPlaceholder.style.display = 'flex';
                thumbnailImg.style.display = 'none';
                updateQC('thumbnail', false);
            }
            
            // Update video preview
            const videoEl = document.getElementById('previewVideoElement');
            const videoPlaceholder = document.querySelector('#previewVideo .preview-placeholder');
            if (videoShort) {
                videoEl.src = '../' + videoShort;
                videoEl.style.display = 'block';
                videoPlaceholder.style.display = 'none';
                updateQC('video', true);
                // Try to play if currently viewing
                if (document.querySelector('.preview-toggle-btn[data-view="video"]').classList.contains('active')) {
                    videoEl.play().catch(() => {});
                }
            } else {
                videoEl.src = '';
                videoEl.style.display = 'none';
                videoPlaceholder.style.display = 'flex';
                updateQC('video', false);
            }
            
            // Update full video preview
            const fullVideoDiv = document.getElementById('previewFullVideo');
            const fullPlaceholder = document.querySelector('#previewFull .preview-placeholder');
            if (videoLong) {
                fullPlaceholder.style.display = 'none';
                fullVideoDiv.style.display = 'block';
                
                // Check if it's a Simian URL
                if (videoLong.includes('gosimian.com') || videoLong.startsWith('http')) {
                    // Create iframe for Simian
                    if (!fullVideoDiv.querySelector('iframe')) {
                        const iframe = document.createElement('iframe');
                        iframe.src = videoLong;
                        iframe.style.width = '100%';
                        iframe.style.height = '100%';
                        iframe.style.border = 'none';
                        iframe.setAttribute('allowFullScreen', '');
                        iframe.setAttribute('webkitAllowFullScreen', '');
                        fullVideoDiv.innerHTML = '';
                        fullVideoDiv.appendChild(iframe);
                    } else {
                        fullVideoDiv.querySelector('iframe').src = videoLong;
                    }
                } else {
                    // Local video file
                    fullVideoDiv.innerHTML = '<video controls style="width: 100%; height: 100%; object-fit: cover;" src="../' + videoLong + '"></video>';
                }
                updateQC('full', true);
            } else {
                fullVideoDiv.innerHTML = '';
                fullVideoDiv.style.display = 'none';
                fullPlaceholder.style.display = 'flex';
                updateQC('full', false);
            }
        }
        
        function updateQC(type, isValid) {
            const qcItem = document.getElementById('qc' + type.charAt(0).toUpperCase() + type.slice(1));
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
        
        function toggleSection(btn) {
            const section = btn.closest('.project-form-section');
            const content = section.querySelector('.section-content');
            const icon = btn.querySelector('i');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                btn.classList.add('active');
            } else {
                content.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                btn.classList.remove('active');
            }
        }
        
        // Initialize preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
</body>
</html>
