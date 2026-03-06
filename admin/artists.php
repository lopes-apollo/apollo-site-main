<?php
require_once 'config.php';
requireLogin();

$artists = getArtists();
$pending = getPendingChanges();
$pending_artists = $pending['artists'] ?? null;
$has_pending = !empty($pending_artists);
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'save_artist') {
        $id = $_POST['id'] ?? uniqid('artist_');
        
        // Get videos from form
        $videos = [];
        if (isset($_POST['videos']) && is_array($_POST['videos'])) {
            foreach ($_POST['videos'] as $video_data) {
                if (!empty($video_data['videoName'])) {
                    $videos[] = [
                        'id' => $video_data['id'] ?? uniqid('video_'),
                        'videoName' => $video_data['videoName'] ?? '',
                        'videoSubName' => $video_data['videoSubName'] ?? '',
                        'videoShort' => $video_data['videoShort'] ?? '',
                        'videoLong' => $video_data['videoLong'] ?? '',
                        'poster' => $video_data['poster'] ?? '',
                        'hasCredit' => isset($video_data['hasCredit']),
                        'credits' => $video_data['credits'] ?? '',
                        'previewImages' => [
                            $video_data['prev1'] ?? '',
                            $video_data['prev2'] ?? '',
                            $video_data['prev3'] ?? '',
                            $video_data['prev4'] ?? '',
                            $video_data['prev5'] ?? '',
                            $video_data['prev6'] ?? ''
                        ],
                        'order' => intval($video_data['order'] ?? 0)
                    ];
                }
            }
        }
        
        $artist = [
            'id' => $id,
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'category' => $_POST['category'] ?? '',
            'videos' => $videos,
            'visible' => isset($_POST['visible'])
        ];
        
        // Update or add to current artists (for display)
        $found = false;
        foreach ($artists as $key => $a) {
            if ($a['id'] === $id) {
                $artists[$key] = $artist;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $artists[] = $artist;
        }
        
        // Sort artists alphabetically by name
        usort($artists, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        
        // Save to pending changes instead of directly
        savePendingChanges(['artists' => $artists]);
        $message = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Changes saved to pending!</strong> Click "Save to Next Sync" below to prepare these changes for the next website sync.</div>';
        $pending_artists = $artists;
        $has_pending = true;
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $artists = array_filter($artists, function($a) use ($id) {
            return $a['id'] !== $id;
        });
        $artists = array_values($artists);
        
        // Save to pending changes
        savePendingChanges(['artists' => $artists]);
        $message = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Deletion saved to pending!</strong> Click "Save to Next Sync" below to prepare this change for the next website sync.</div>';
        $pending_artists = $artists;
        $has_pending = true;
    } elseif ($action === 'save_to_sync') {
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Changes saved for next sync!</strong> Go to <a href="sync.php">Sync to Website</a> to apply these changes.</div>';
    }
    
    // Refresh data
    $artists = getArtists();
    $pending = getPendingChanges();
    $pending_artists = $pending['artists'] ?? null;
    $has_pending = !empty($pending_artists);
}

$editing = null;
if (isset($_GET['edit'])) {
    foreach ($artists as $a) {
        if ($a['id'] === $_GET['edit']) {
            $editing = $a;
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
    <title>Artists - Apollo CMS</title>
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
        
        /* Video Form Sections */
        .video-form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .video-form-section:last-child {
            border-bottom: none;
        }
        
        .section-title-small {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .toggle-section {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .toggle-section.active {
            transform: rotate(180deg);
        }
        
        /* Preview Toggle Controls */
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
            font-size: 13px;
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
            margin-top: 15px;
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
            font-size: 36px;
            margin-bottom: 8px;
            display: block;
        }
        
        .preview-placeholder p {
            margin: 8px 0 4px 0;
            font-size: 14px;
        }
        
        .preview-placeholder small {
            font-size: 11px;
        }
        
        /* Quality Control */
        .quality-control {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding: 12px;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
        }
        
        .qc-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 12px;
        }
        
        .qc-item i {
            font-size: 16px;
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
            <h1><i class="fas fa-users"></i> Artists</h1>
            <a href="?action=add" class="btn-primary"><i class="fas fa-plus"></i> Add Artist</a>
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
        
        <?php echo $message; ?>
        
        <?php if ($editing || isset($_GET['action']) && $_GET['action'] === 'add'): ?>
            <!-- Edit/Add Form -->
            <div class="content-card">
                <h2><?php echo $editing ? 'Edit Artist' : 'Add New Artist'; ?></h2>
                <form method="POST" id="artistForm">
                    <input type="hidden" name="action" value="save_artist">
                    <input type="hidden" name="id" value="<?php echo $editing['id'] ?? ''; ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Artist Name *</label>
                                <input type="text" class="form-control" name="name" 
                                       value="<?php echo htmlspecialchars($editing['name'] ?? ''); ?>" required
                                       onchange="updateSlug(this.value)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">URL Slug *</label>
                                <input type="text" class="form-control" name="slug" 
                                       value="<?php echo htmlspecialchars($editing['slug'] ?? ''); ?>" required>
                                <small class="text-muted">e.g., jamil-shaukat (used in URLs: /roster/jamil-shaukat)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category...</option>
                                    <?php foreach (CATEGORIES as $cat): ?>
                                        <option value="<?php echo $cat; ?>" 
                                                <?php echo ($editing['category'] ?? '') === $cat ? 'selected' : ''; ?>>
                                            <?php echo CATEGORY_LABELS[$cat]; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">This is the artist's category tag (Editor, Colorist, Sound Designer, or VFX Artist). Roster assignments are managed separately in the Roster tab.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input custom-checkbox" name="visible" id="visible" 
                                   <?php echo ($editing['visible'] ?? true) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="visible">Visible on Website</label>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="mb-0">Artist Videos</h3>
                            <p class="text-muted mb-0">Click on a video to edit its details</p>
                        </div>
                        <button type="button" class="btn-add-video" onclick="addVideo()">
                            <i class="fas fa-plus"></i> Add Video
                        </button>
                    </div>
                    
                    <div id="videosContainer" class="sortable-videos">
                        <?php 
                        $artist_videos = $editing['videos'] ?? [];
                        foreach ($artist_videos as $idx => $video): 
                            $video_id = $video['id'] ?? uniqid('video_');
                            $video_name = htmlspecialchars($video['videoName'] ?? 'Untitled Video');
                        ?>
                            <div class="video-item-compact" data-video-id="<?php echo $video_id; ?>" data-video-index="<?php echo $idx; ?>" draggable="true">
                                <div class="video-item-header-compact">
                                    <div class="video-drag-handle" title="Drag to reorder">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                    <div class="video-item-info" onclick="toggleVideoEdit(<?php echo $idx; ?>)">
                                        <i class="fas fa-video"></i>
                                        <span class="video-item-name"><?php echo $video_name; ?></span>
                                        <?php if (!empty($video['videoSubName'])): ?>
                                            <span class="video-item-subtitle"> - <?php echo htmlspecialchars($video['videoSubName']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="video-item-actions">
                                        <button type="button" class="btn-remove-video-compact" onclick="event.stopPropagation(); removeVideo(<?php echo $idx; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <i class="fas fa-chevron-down video-toggle-icon" onclick="toggleVideoEdit(<?php echo $idx; ?>)"></i>
                                    </div>
                                </div>
                                
                                <div class="video-item-details" id="video-details-<?php echo $idx; ?>" style="display: none;">
                                    <input type="hidden" name="videos[<?php echo $idx; ?>][id]" value="<?php echo $video_id; ?>">
                                    
                                    <!-- Basic Info Section -->
                                    <div class="video-form-section">
                                        <h4 class="section-title-small">Basic Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Video Name *</label>
                                                    <input type="text" class="form-control" name="videos[<?php echo $idx; ?>][videoName]" 
                                                           value="<?php echo htmlspecialchars($video['videoName'] ?? ''); ?>" 
                                                           required oninput="updateVideoPreview(<?php echo $idx; ?>)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Video Subtitle</label>
                                                    <input type="text" class="form-control" name="videos[<?php echo $idx; ?>][videoSubName]" 
                                                           value="<?php echo htmlspecialchars($video['videoSubName'] ?? ''); ?>"
                                                           oninput="updateVideoPreview(<?php echo $idx; ?>)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Visual Preview Section -->
                                    <div class="video-form-section">
                                        <h4 class="section-title-small">Visual Preview & Quality Control</h4>
                                        
                                        <!-- Preview Toggle Buttons -->
                                        <div class="preview-toggle-controls">
                                            <button type="button" class="preview-toggle-btn active" data-view="video" onclick="switchVideoPreview(<?php echo $idx; ?>, 'video')">
                                                <i class="fas fa-video"></i> Video Preview
                                            </button>
                                            <button type="button" class="preview-toggle-btn" data-view="full" onclick="switchVideoPreview(<?php echo $idx; ?>, 'full')">
                                                <i class="fas fa-play-circle"></i> Full Video
                                            </button>
                                            <button type="button" class="preview-toggle-btn" data-view="thumbnail" onclick="switchVideoPreview(<?php echo $idx; ?>, 'thumbnail')">
                                                <i class="fas fa-image"></i> Image Thumbnail
                                            </button>
                                        </div>
                                        
                                        <!-- Preview Frame (16:9) -->
                                        <div class="preview-frame-container">
                                            <div class="preview-frame" id="previewFrame-<?php echo $idx; ?>">
                                                <!-- Video Preview View -->
                                                <div class="preview-content active" id="previewVideo-<?php echo $idx; ?>">
                                                    <div class="preview-placeholder">
                                                        <i class="fas fa-video"></i>
                                                        <p>Video Preview</p>
                                                        <small>Set short video path below</small>
                                                    </div>
                                                    <video id="previewVideoElement-<?php echo $idx; ?>" src="" muted loop playsinline style="display: none; width: 100%; height: 100%; object-fit: cover;"></video>
                                                </div>
                                                
                                                <!-- Full Video View -->
                                                <div class="preview-content" id="previewFull-<?php echo $idx; ?>">
                                                    <div class="preview-placeholder">
                                                        <i class="fas fa-play-circle"></i>
                                                        <p>Full Video</p>
                                                        <small>Set full video URL below</small>
                                                    </div>
                                                    <div id="previewFullVideo-<?php echo $idx; ?>" style="display: none; width: 100%; height: 100%;"></div>
                                                </div>
                                                
                                                <!-- Thumbnail View -->
                                                <div class="preview-content" id="previewThumbnail-<?php echo $idx; ?>">
                                                    <div class="preview-placeholder">
                                                        <i class="fas fa-image"></i>
                                                        <p>Image Thumbnail</p>
                                                        <small>Set poster image below</small>
                                                    </div>
                                                    <img id="previewThumbnailImg-<?php echo $idx; ?>" src="" alt="Thumbnail" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            </div>
                                            
                                            <!-- Quality Control Checkmarks -->
                                            <div class="quality-control">
                                                <div class="qc-item" id="qcVideo-<?php echo $idx; ?>">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Video Preview</span>
                                                </div>
                                                <div class="qc-item" id="qcFull-<?php echo $idx; ?>">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Full Video</span>
                                                </div>
                                                <div class="qc-item" id="qcThumbnail-<?php echo $idx; ?>">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Thumbnail</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Media URLs Section (Collapsible) -->
                                    <div class="video-form-section">
                                        <h4 class="section-title-small">
                                            <span>Media URLs</span>
                                            <button type="button" class="toggle-section" onclick="toggleVideoSection(this)">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </h4>
                                        <div class="section-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Short Video (Preview) *</label>
                                                        <input type="text" class="form-control" name="videos[<?php echo $idx; ?>][videoShort]" 
                                                               value="<?php echo htmlspecialchars($video['videoShort'] ?? ''); ?>" 
                                                               required oninput="updateVideoPreview(<?php echo $idx; ?>)">
                                                        <small class="text-muted">e.g., videos/short/nv1.mp4</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Long Video (Full) *</label>
                                                        <input type="text" class="form-control" name="videos[<?php echo $idx; ?>][videoLong]" 
                                                               value="<?php echo htmlspecialchars($video['videoLong'] ?? ''); ?>" 
                                                               required oninput="updateVideoPreview(<?php echo $idx; ?>)">
                                                        <small class="text-muted">Full video URL (Simian embed URL or local path)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Poster Image</label>
                                                <input type="text" class="form-control" name="videos[<?php echo $idx; ?>][poster]" 
                                                       value="<?php echo htmlspecialchars($video['poster'] ?? ''); ?>"
                                                       oninput="updateVideoPreview(<?php echo $idx; ?>)">
                                                <small class="text-muted">Thumbnail/poster image path</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Additional Settings (Collapsible) -->
                                    <div class="video-form-section">
                                        <h4 class="section-title-small">
                                            <span>Additional Settings</span>
                                            <button type="button" class="toggle-section" onclick="toggleVideoSection(this)">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </h4>
                                        <div class="section-content" style="display: none;">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input custom-checkbox" id="hasCredit_<?php echo $idx; ?>" name="videos[<?php echo $idx; ?>][hasCredit]" 
                                                           <?php echo ($video['hasCredit'] ?? false) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="hasCredit_<?php echo $idx; ?>">Show Credits</label>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Credits (HTML allowed)</label>
                                                <textarea class="form-control" name="videos[<?php echo $idx; ?>][credits]" rows="3"><?php echo htmlspecialchars($video['credits'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Preview Images (up to 6)</label>
                                                <div class="row">
                                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                                        <div class="col-md-4 mb-2">
                                                            <input type="text" class="form-control form-control-sm" 
                                                                   name="videos[<?php echo $idx; ?>][prev<?php echo $i; ?>]" 
                                                                   placeholder="Preview <?php echo $i; ?>" 
                                                                   value="<?php echo htmlspecialchars($video['previewImages'][$i-1] ?? ''); ?>">
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="form-actions mt-4">
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Artist</button>
                        <a href="artists.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- All Artists List -->
            <div class="content-card">
                <p class="text-muted mb-4">Manage all artists here. Assign category tags to identify their type (Editor, Colorist, Sound Designer, or VFX Artist). To assign artists to roster sections for website display, use the <a href="roster.php">Roster</a> tab.</p>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Artist Name</th>
                            <th>Slug</th>
                            <th>Category Tag</th>
                            <th>Videos</th>
                            <th>Visible</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($artists)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No artists yet. <a href="?action=add">Add your first artist</a></td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            // Sort all artists alphabetically by name
                            usort($artists, function($a, $b) {
                                return strcasecmp($a['name'], $b['name']);
                            });
                            foreach ($artists as $artist): 
                            ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($artist['name']); ?></strong></td>
                                    <td><code><?php echo htmlspecialchars($artist['slug'] ?? ''); ?></code></td>
                                    <td>
                                        <?php if (!empty($artist['category'])): ?>
                                            <span class="badge bg-info"><?php echo CATEGORY_LABELS[$artist['category']] ?? $artist['category']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No category</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo count($artist['videos'] ?? []); ?> videos</span>
                                    </td>
                                    <td>
                                        <?php if ($artist['visible'] ?? true): ?>
                                            <span class="badge bg-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $artist['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this artist and all their videos?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $artist['id']; ?>">
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
        let videoCount = <?php echo count($editing['videos'] ?? []); ?>;
        
        function updateSlug(name) {
            const slugInput = document.querySelector('input[name="slug"]');
            if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                slugInput.value = name.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.dataset.autoGenerated = 'true';
            }
        }
        
        function toggleVideoEdit(index) {
            const videoItem = document.querySelector(`[data-video-index="${index}"]`);
            const detailsDiv = document.getElementById(`video-details-${index}`);
            
            if (videoItem && detailsDiv) {
                const isExpanded = videoItem.classList.contains('expanded');
                
                // Close all other videos
                document.querySelectorAll('.video-item-compact').forEach(item => {
                    item.classList.remove('expanded');
                    const details = item.querySelector('.video-item-details');
                    if (details) {
                        details.style.display = 'none';
                    }
                });
                
                // Toggle current video
                if (!isExpanded) {
                    videoItem.classList.add('expanded');
                    detailsDiv.style.display = 'block';
                    // Initialize preview when opening
                    setTimeout(() => updateVideoPreview(index), 100);
                }
            }
        }
        
        function switchVideoPreview(index, view) {
            // Update toggle buttons for this video
            const videoItem = document.querySelector(`[data-video-index="${index}"]`);
            videoItem.querySelectorAll('.preview-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-view') === view) {
                    btn.classList.add('active');
                }
            });
            
            // Update preview content
            document.getElementById(`previewVideo-${index}`).classList.remove('active');
            document.getElementById(`previewFull-${index}`).classList.remove('active');
            document.getElementById(`previewThumbnail-${index}`).classList.remove('active');
            
            if (view === 'video') {
                document.getElementById(`previewVideo-${index}`).classList.add('active');
                const videoEl = document.getElementById(`previewVideoElement-${index}`);
                if (videoEl && videoEl.src) {
                    videoEl.play().catch(() => {});
                }
            } else if (view === 'full') {
                document.getElementById(`previewFull-${index}`).classList.add('active');
            } else if (view === 'thumbnail') {
                document.getElementById(`previewThumbnail-${index}`).classList.add('active');
            }
        }
        
        function updateVideoPreview(index) {
            const videoItem = document.querySelector(`[data-video-index="${index}"]`);
            if (!videoItem) return;
            
            const videoShort = videoItem.querySelector('input[name*="[videoShort]"]')?.value || '';
            const videoLong = videoItem.querySelector('input[name*="[videoLong]"]')?.value || '';
            const poster = videoItem.querySelector('input[name*="[poster]"]')?.value || '';
            
            // Update video preview
            const videoEl = document.getElementById(`previewVideoElement-${index}`);
            const videoPlaceholder = document.querySelector(`#previewVideo-${index} .preview-placeholder`);
            if (videoShort && videoEl) {
                videoEl.src = '../' + videoShort;
                videoEl.style.display = 'block';
                if (videoPlaceholder) videoPlaceholder.style.display = 'none';
                updateVideoQC(index, 'video', true);
                // Try to play if currently viewing
                if (document.querySelector(`[data-video-index="${index}"] .preview-toggle-btn[data-view="video"]`)?.classList.contains('active')) {
                    videoEl.play().catch(() => {});
                }
            } else {
                if (videoEl) videoEl.src = '';
                if (videoEl) videoEl.style.display = 'none';
                if (videoPlaceholder) videoPlaceholder.style.display = 'flex';
                updateVideoQC(index, 'video', false);
            }
            
            // Update full video preview
            const fullVideoDiv = document.getElementById(`previewFullVideo-${index}`);
            const fullPlaceholder = document.querySelector(`#previewFull-${index} .preview-placeholder`);
            if (videoLong && fullVideoDiv) {
                if (fullPlaceholder) fullPlaceholder.style.display = 'none';
                fullVideoDiv.style.display = 'block';
                
                // Check if it's already formatted HTML with iframe
                if (videoLong.includes('<iframe')) {
                    // Already formatted HTML - use as is
                    fullVideoDiv.innerHTML = videoLong;
                } else if (videoLong.includes('gosimian.com') || (videoLong.startsWith('http') && !videoLong.includes('<'))) {
                    // Simian URL - wrap in responsive container
                    fullVideoDiv.innerHTML = '<div style="width:100%;height:0;position: relative;padding-bottom:56.25%;"><iframe src="' + 
                                             escapeHtml(videoLong) + 
                                             '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
                } else {
                    // Local video file
                    fullVideoDiv.innerHTML = '<video controls style="width: 100%; height: 100%; object-fit: cover;" src="../' + escapeHtml(videoLong) + '"></video>';
                }
                updateVideoQC(index, 'full', true);
            } else {
                if (fullVideoDiv) fullVideoDiv.innerHTML = '';
                if (fullVideoDiv) fullVideoDiv.style.display = 'none';
                if (fullPlaceholder) fullPlaceholder.style.display = 'flex';
                updateVideoQC(index, 'full', false);
            }
            
            // Update thumbnail preview
            const thumbnailImg = document.getElementById(`previewThumbnailImg-${index}`);
            const thumbnailPlaceholder = document.querySelector(`#previewThumbnail-${index} .preview-placeholder`);
            if (poster && thumbnailImg) {
                thumbnailImg.src = '../' + poster;
                thumbnailImg.onerror = function() {
                    this.style.display = 'none';
                    if (thumbnailPlaceholder) thumbnailPlaceholder.style.display = 'flex';
                    updateVideoQC(index, 'thumbnail', false);
                };
                thumbnailImg.onload = function() {
                    this.style.display = 'block';
                    if (thumbnailPlaceholder) thumbnailPlaceholder.style.display = 'none';
                    updateVideoQC(index, 'thumbnail', true);
                };
                thumbnailImg.style.display = 'block';
                if (thumbnailPlaceholder) thumbnailPlaceholder.style.display = 'none';
                updateVideoQC(index, 'thumbnail', true);
            } else {
                if (thumbnailImg) thumbnailImg.style.display = 'none';
                if (thumbnailPlaceholder) thumbnailPlaceholder.style.display = 'flex';
                updateVideoQC(index, 'thumbnail', false);
            }
        }
        
        function updateVideoQC(index, type, isValid) {
            const qcItem = document.getElementById(`qc${type.charAt(0).toUpperCase() + type.slice(1)}-${index}`);
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
        
        function toggleVideoSection(btn) {
            const section = btn.closest('.video-form-section');
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
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Initialize previews for existing videos on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.video-item-compact').forEach((item, idx) => {
                const index = item.getAttribute('data-video-index');
                if (index !== null) {
                    setTimeout(() => updateVideoPreview(parseInt(index)), 100);
                }
            });
        });
        
        function addVideo() {
            const container = document.getElementById('videosContainer');
            const videoId = 'video_' + Date.now();
            const videoHtml = `
                <div class="video-item-compact expanded" data-video-id="${videoId}" data-video-index="${videoCount}" draggable="true">
                    <div class="video-item-header-compact">
                        <div class="video-drag-handle" title="Drag to reorder">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="video-item-info" onclick="toggleVideoEdit(${videoCount})">
                            <i class="fas fa-video"></i>
                            <span class="video-item-name">New Video</span>
                        </div>
                        <div class="video-item-actions">
                            <button type="button" class="btn-remove-video-compact" onclick="event.stopPropagation(); removeVideo(${videoCount})">
                                <i class="fas fa-trash"></i>
                            </button>
                            <i class="fas fa-chevron-down video-toggle-icon" onclick="toggleVideoEdit(${videoCount})"></i>
                        </div>
                    </div>
                    
                    <div class="video-item-details" id="video-details-${videoCount}" style="display: block;">
                        <input type="hidden" name="videos[${videoCount}][id]" value="${videoId}">
                        
                        <!-- Basic Info Section -->
                        <div class="video-form-section">
                            <h4 class="section-title-small">Basic Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Video Name *</label>
                                        <input type="text" class="form-control" name="videos[${videoCount}][videoName]" 
                                               required oninput="updateVideoPreview(${videoCount})">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Video Subtitle</label>
                                        <input type="text" class="form-control" name="videos[${videoCount}][videoSubName]"
                                               oninput="updateVideoPreview(${videoCount})">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Visual Preview Section -->
                        <div class="video-form-section">
                            <h4 class="section-title-small">Visual Preview & Quality Control</h4>
                            
                            <!-- Preview Toggle Buttons -->
                            <div class="preview-toggle-controls">
                                <button type="button" class="preview-toggle-btn active" data-view="video" onclick="switchVideoPreview(${videoCount}, 'video')">
                                    <i class="fas fa-video"></i> Video Preview
                                </button>
                                <button type="button" class="preview-toggle-btn" data-view="full" onclick="switchVideoPreview(${videoCount}, 'full')">
                                    <i class="fas fa-play-circle"></i> Full Video
                                </button>
                                <button type="button" class="preview-toggle-btn" data-view="thumbnail" onclick="switchVideoPreview(${videoCount}, 'thumbnail')">
                                    <i class="fas fa-image"></i> Image Thumbnail
                                </button>
                            </div>
                            
                            <!-- Preview Frame (16:9) -->
                            <div class="preview-frame-container">
                                <div class="preview-frame" id="previewFrame-${videoCount}">
                                    <!-- Video Preview View -->
                                    <div class="preview-content active" id="previewVideo-${videoCount}">
                                        <div class="preview-placeholder">
                                            <i class="fas fa-video"></i>
                                            <p>Video Preview</p>
                                            <small>Set short video path below</small>
                                        </div>
                                        <video id="previewVideoElement-${videoCount}" src="" muted loop playsinline style="display: none; width: 100%; height: 100%; object-fit: cover;"></video>
                                    </div>
                                    
                                    <!-- Full Video View -->
                                    <div class="preview-content" id="previewFull-${videoCount}">
                                        <div class="preview-placeholder">
                                            <i class="fas fa-play-circle"></i>
                                            <p>Full Video</p>
                                            <small>Set full video URL below</small>
                                        </div>
                                        <div id="previewFullVideo-${videoCount}" style="display: none; width: 100%; height: 100%;"></div>
                                    </div>
                                    
                                    <!-- Thumbnail View -->
                                    <div class="preview-content" id="previewThumbnail-${videoCount}">
                                        <div class="preview-placeholder">
                                            <i class="fas fa-image"></i>
                                            <p>Image Thumbnail</p>
                                            <small>Set poster image below</small>
                                        </div>
                                        <img id="previewThumbnailImg-${videoCount}" src="" alt="Thumbnail" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                                
                                <!-- Quality Control Checkmarks -->
                                <div class="quality-control">
                                    <div class="qc-item" id="qcVideo-${videoCount}">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Video Preview</span>
                                    </div>
                                    <div class="qc-item" id="qcFull-${videoCount}">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Full Video</span>
                                    </div>
                                    <div class="qc-item" id="qcThumbnail-${videoCount}">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Thumbnail</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Media URLs Section (Collapsible) -->
                        <div class="video-form-section">
                            <h4 class="section-title-small">
                                <span>Media URLs</span>
                                <button type="button" class="toggle-section" onclick="toggleVideoSection(this)">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </h4>
                            <div class="section-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Short Video (Preview) *</label>
                                            <input type="text" class="form-control" name="videos[${videoCount}][videoShort]" 
                                                   required oninput="updateVideoPreview(${videoCount})">
                                            <small class="text-muted">e.g., videos/short/nv1.mp4</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Long Video (Full) *</label>
                                            <input type="text" class="form-control" name="videos[${videoCount}][videoLong]" 
                                                   required oninput="updateVideoPreview(${videoCount})">
                                            <small class="text-muted">Full video URL (Simian embed URL or local path)</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Poster Image</label>
                                    <input type="text" class="form-control" name="videos[${videoCount}][poster]"
                                           oninput="updateVideoPreview(${videoCount})">
                                    <small class="text-muted">Thumbnail/poster image path</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Settings (Collapsible) -->
                        <div class="video-form-section">
                            <h4 class="section-title-small">
                                <span>Additional Settings</span>
                                <button type="button" class="toggle-section" onclick="toggleVideoSection(this)">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </h4>
                            <div class="section-content" style="display: none;">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input custom-checkbox" id="hasCredit_${videoCount}" name="videos[${videoCount}][hasCredit]">
                                        <label class="form-check-label" for="hasCredit_${videoCount}">Show Credits</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Credits (HTML allowed)</label>
                                    <textarea class="form-control" name="videos[${videoCount}][credits]" rows="3"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Preview Images (up to 6)</label>
                                    <div class="row">
                                        ${[1,2,3,4,5,6].map(i => `
                                            <div class="col-md-4 mb-2">
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="videos[${videoCount}][prev${i}]" placeholder="Preview ${i}">
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', videoHtml);
            videoCount++;
            
            // Update video names in list when they change
            updateVideoListNames();
            // Initialize preview for new video
            setTimeout(() => updateVideoPreview(videoCount - 1), 100);
        }
        
        function removeVideo(index) {
            if (confirm('Remove this video?')) {
                const videoItem = document.querySelector(`[data-video-index="${index}"]`);
                if (videoItem) {
                    videoItem.remove();
                    // Re-index remaining videos
                    reindexVideos();
                    updateVideoListNames();
                }
            }
        }
        
        function reindexVideos() {
            const container = document.getElementById('videosContainer');
            const items = container.querySelectorAll('.video-item-compact');
            items.forEach((item, newIndex) => {
                const oldIndex = item.getAttribute('data-video-index');
                item.setAttribute('data-video-index', newIndex);
                const detailsDiv = item.querySelector('.video-item-details');
                if (detailsDiv) {
                    detailsDiv.id = `video-details-${newIndex}`;
                }
                const header = item.querySelector('.video-item-header-compact');
                if (header) {
                    header.setAttribute('onclick', `toggleVideoEdit(${newIndex})`);
                }
                const removeBtn = item.querySelector('.btn-remove-video-compact');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `event.stopPropagation(); removeVideo(${newIndex})`);
                }
                // Update all input names and preview element IDs
                const inputs = item.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.startsWith('videos[')) {
                        input.setAttribute('name', name.replace(/videos\[\d+\]/, `videos[${newIndex}]`));
                    }
                    // Update oninput handlers
                    if (input.hasAttribute('oninput') && input.getAttribute('oninput').includes('updateVideoPreview')) {
                        input.setAttribute('oninput', `updateVideoPreview(${newIndex})`);
                    }
                });
                // Update preview element IDs
                ['previewFrame', 'previewVideo', 'previewFull', 'previewThumbnail', 'previewVideoElement', 'previewFullVideo', 'previewThumbnailImg', 'qcVideo', 'qcFull', 'qcThumbnail'].forEach(idPrefix => {
                    const oldId = `${idPrefix}-${oldIndex}`;
                    const newId = `${idPrefix}-${newIndex}`;
                    const element = item.querySelector(`#${oldId}`);
                    if (element) {
                        element.id = newId;
                    }
                });
                // Update toggle button onclick handlers
                item.querySelectorAll('.preview-toggle-btn').forEach(btn => {
                    const view = btn.getAttribute('data-view');
                    btn.setAttribute('onclick', `switchVideoPreview(${newIndex}, '${view}')`);
                });
                // Update toggle section buttons
                item.querySelectorAll('.toggle-section').forEach(btn => {
                    btn.setAttribute('onclick', 'toggleVideoSection(this)');
                });
            });
        }
        
        function updateVideoListNames() {
            const items = document.querySelectorAll('.video-item-compact');
            items.forEach(item => {
                const nameInput = item.querySelector('input[name*="[videoName]"]');
                const nameSpan = item.querySelector('.video-item-name');
                const subtitleInput = item.querySelector('input[name*="[videoSubName]"]');
                const subtitleSpan = item.querySelector('.video-item-subtitle');
                
                if (nameInput && nameSpan) {
                    // Update on input change
                    nameInput.addEventListener('input', function() {
                        nameSpan.textContent = this.value || 'Untitled Video';
                    });
                }
                
                if (subtitleInput && subtitleSpan) {
                    subtitleInput.addEventListener('input', function() {
                        if (this.value) {
                            if (!subtitleSpan) {
                                const subtitleSpanNew = document.createElement('span');
                                subtitleSpanNew.className = 'video-item-subtitle';
                                nameSpan.parentNode.appendChild(subtitleSpanNew);
                            }
                            const existingSubtitle = item.querySelector('.video-item-subtitle');
                            if (existingSubtitle) {
                                existingSubtitle.textContent = ' - ' + this.value;
                            }
                        } else {
                            const existingSubtitle = item.querySelector('.video-item-subtitle');
                            if (existingSubtitle) {
                                existingSubtitle.remove();
                            }
                        }
                    });
                }
            });
        }
        
        // Drag and Drop functionality
        let draggedElement = null;
        
        function initDragAndDrop() {
            const container = document.getElementById('videosContainer');
            if (!container) return;
            
            const items = container.querySelectorAll('.video-item-compact');
            
            items.forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragover', handleDragOver);
                item.addEventListener('drop', handleDrop);
                item.addEventListener('dragend', handleDragEnd);
            });
        }
        
        function handleDragStart(e) {
            draggedElement = this;
            this.style.opacity = '0.5';
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }
        
        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';
            
            const afterElement = getDragAfterElement(this.parentNode, e.clientY);
            const dragging = document.querySelector('.dragging');
            
            if (afterElement == null) {
                this.parentNode.appendChild(draggedElement);
            } else {
                this.parentNode.insertBefore(draggedElement, afterElement);
            }
            
            return false;
        }
        
        function handleDrop(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            }
            
            if (draggedElement !== this) {
                // Reorder has happened
                reindexVideos();
            }
            
            return false;
        }
        
        function handleDragEnd(e) {
            this.style.opacity = '1';
            
            const items = document.querySelectorAll('.video-item-compact');
            items.forEach(item => {
                item.classList.remove('dragging');
            });
            
            draggedElement = null;
        }
        
        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.video-item-compact:not(.dragging)')];
            
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
        
        // Initialize drag and drop on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateVideoListNames();
            initDragAndDrop();
            
            // Re-initialize drag and drop after adding/removing videos
            const observer = new MutationObserver(function(mutations) {
                initDragAndDrop();
            });
            
            const container = document.getElementById('videosContainer');
            if (container) {
                observer.observe(container, { childList: true, subtree: true });
            }
        });
    </script>
</body>
</html>
