<?php
require_once 'config.php';
requireLogin();

$projects = getLandingPageProjects();
$allVideos = getVideos();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'save') {
        $id = !empty($_POST['id']) ? $_POST['id'] : uniqid('proj_', true);
        $project = [
            'id' => $id,
            'video_id' => $_POST['video_id'] ?? '',
            'image_class' => $_POST['image_class'] ?? 'bgimage' . (count($projects) + 1),
            'title_override' => $_POST['title_override'] ?? '',
            'subtitle_override' => $_POST['subtitle_override'] ?? '',
            'author' => $_POST['author'] ?? '',
            'order' => intval($_POST['order'] ?? count($projects)),
            'visible' => isset($_POST['visible'])
        ];
        
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
        
        usort($projects, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        saveLandingPageProjects($projects);
        savePendingChanges(['landing_page' => $projects]);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Project saved!</strong></div>';
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $projects = array_values(array_filter($projects, function($p) use ($id) {
            return $p['id'] !== $id;
        }));
        
        saveLandingPageProjects($projects);
        savePendingChanges(['landing_page' => $projects]);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Project deleted.</strong></div>';
    } elseif ($action === 'reorder') {
        $order_ids = $_POST['order_ids'] ?? [];
        if (!empty($order_ids)) {
            $indexed = [];
            foreach ($projects as $p) {
                $indexed[$p['id']] = $p;
            }
            $reordered = [];
            foreach ($order_ids as $idx => $pid) {
                if (isset($indexed[$pid])) {
                    $proj = $indexed[$pid];
                    $proj['order'] = (int)$idx;
                    $reordered[] = $proj;
                }
            }
            saveLandingPageProjects($reordered);
            savePendingChanges(['landing_page' => $reordered]);
            $projects = $reordered;
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Order saved!</strong></div>';
        }
    }
    
    clearCache();
    $projects = getLandingPageProjects();
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

$editingVideo = null;
if ($editing && !empty($editing['video_id'])) {
    $editingVideo = getVideoById($editing['video_id']);
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
        .video-picker-search-lp { position: relative; margin-bottom: 10px; }
        .video-picker-search-lp input { padding-left: 36px; }
        .video-picker-search-lp i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-3); }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-home"></i> Landing Page Projects</h1>
            <a href="?action=add" class="btn-primary"><i class="fas fa-plus"></i> Add Project</a>
        </div>
        
        <?php echo $message; ?>
        
        <?php if ($editing || isset($_GET['action']) && $_GET['action'] === 'add'): ?>
            <!-- Edit/Add Form -->
            <div class="content-card">
                <h2><?php echo $editing ? 'Edit Project' : 'Add New Project'; ?></h2>
                <form method="POST" id="projectForm">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editing['id'] ?? ''); ?>">
                    <input type="hidden" name="video_id" id="videoIdInput" value="<?php echo htmlspecialchars($editing['video_id'] ?? ''); ?>">
                    
                    <!-- Video Picker Section -->
                    <div class="project-form-section">
                        <h3 class="section-title">Pool Video</h3>
                        
                        <div id="selectedVideoDisplay">
                            <?php if ($editingVideo): ?>
                                <div class="video-picker-selected">
                                    <?php if (!empty($editingVideo['poster'])): ?>
                                        <img class="vps-thumb" src="../roster/<?php echo htmlspecialchars($editingVideo['poster']); ?>" alt="">
                                    <?php else: ?>
                                        <div class="vps-thumb" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-film" style="color:var(--text-3);font-size:24px;"></i></div>
                                    <?php endif; ?>
                                    <div class="vps-info">
                                        <h5><?php echo htmlspecialchars($editingVideo['title']); ?></h5>
                                        <small><?php echo htmlspecialchars($editingVideo['subtitle'] ?? ''); ?></small><br>
                                        <small class="text-muted">ID: <?php echo htmlspecialchars($editingVideo['id']); ?></small>
                                    </div>
                                    <div class="vps-actions">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearVideoSelection()">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="video-picker-selected empty">
                                    <span><i class="fas fa-film"></i> No video selected &mdash; pick one below</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="video-picker-search">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="videoSearchInput" placeholder="Search videos by title or subtitle..." oninput="filterVideoPicker()">
                        </div>
                        
                        <div class="video-picker-grid" id="videoPickerGrid">
                            <?php if (empty($allVideos)): ?>
                                <div class="video-picker-empty">
                                    <i class="fas fa-inbox"></i>
                                    <p>No videos in the pool. <a href="video-pool.php">Add videos first</a>.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($allVideos as $v): ?>
                                    <div class="video-picker-item <?php echo ($editing && ($editing['video_id'] ?? '') === $v['id']) ? 'selected' : ''; ?>"
                                         data-video-id="<?php echo htmlspecialchars($v['id']); ?>"
                                         data-title="<?php echo htmlspecialchars($v['title']); ?>"
                                         data-subtitle="<?php echo htmlspecialchars($v['subtitle'] ?? ''); ?>"
                                         data-poster="<?php echo htmlspecialchars($v['poster'] ?? ''); ?>"
                                         data-short="<?php echo htmlspecialchars($v['videoShort'] ?? ''); ?>"
                                         data-long="<?php echo htmlspecialchars($v['videoLong'] ?? ''); ?>"
                                         onclick="selectVideo(this)">
                                        <?php if (!empty($v['poster'])): ?>
                                            <img class="vpi-thumb" src="../roster/<?php echo htmlspecialchars($v['poster']); ?>" alt="" loading="lazy">
                                        <?php else: ?>
                                            <div class="vpi-thumb" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-film" style="color:var(--text-3);"></i></div>
                                        <?php endif; ?>
                                        <div class="vpi-info">
                                            <div class="vpi-title"><?php echo htmlspecialchars($v['title']); ?></div>
                                            <div class="vpi-sub"><?php echo htmlspecialchars($v['subtitle'] ?? ''); ?></div>
                                        </div>
                                        <div class="vpi-check">
                                            <?php if ($editing && ($editing['video_id'] ?? '') === $v['id']): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Display Overrides Section -->
                    <div class="project-form-section">
                        <h3 class="section-title">Display Overrides</h3>
                        <p class="text-muted mb-3" style="font-size:13px;">These override the video pool title/subtitle for this landing page entry only. Leave blank to use the pool video's values.</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title Override</label>
                                    <input type="text" class="form-control" name="title_override" id="titleOverrideInput"
                                           value="<?php echo htmlspecialchars($editing['title_override'] ?? ''); ?>"
                                           placeholder="<?php echo htmlspecialchars($editingVideo['title'] ?? 'Pool video title'); ?>"
                                           oninput="updatePreview()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Subtitle Override</label>
                                    <input type="text" class="form-control" name="subtitle_override" id="subtitleOverrideInput"
                                           value="<?php echo htmlspecialchars($editing['subtitle_override'] ?? ''); ?>"
                                           placeholder="<?php echo htmlspecialchars($editingVideo['subtitle'] ?? 'Pool video subtitle'); ?>"
                                           oninput="updatePreview()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Category *</label>
                                    <select class="form-control" name="author" required>
                                        <option value="">Select...</option>
                                        <?php foreach (CATEGORY_LABELS as $key => $label): ?>
                                            <option value="<?php echo $key; ?>" <?php echo ($editing['author'] ?? '') === $key ? 'selected' : ''; ?>>
                                                <?php echo $label; ?> (<?php echo $key; ?>)
                                            </option>
                                        <?php endforeach; ?>
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
                        
                        <div class="preview-toggle-controls">
                            <button type="button" class="preview-toggle-btn active" data-view="video" onclick="switchPreview('video')">
                                <i class="fas fa-video"></i> Video Preview
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="full" onclick="switchPreview('full')">
                                <i class="fas fa-play-circle"></i> Full Video
                            </button>
                            <button type="button" class="preview-toggle-btn" data-view="thumbnail" onclick="switchPreview('thumbnail')">
                                <i class="fas fa-image"></i> Poster
                            </button>
                        </div>
                        
                        <div class="preview-frame-container">
                            <div class="preview-frame" id="previewFrame">
                                <div class="preview-content active" id="previewVideo">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-video"></i>
                                        <p>Video Preview</p>
                                        <small>Select a pool video above</small>
                                    </div>
                                    <video id="previewVideoElement" src="" muted loop playsinline style="display: none; width: 100%; height: 100%; object-fit: cover;"></video>
                                </div>
                                <div class="preview-content" id="previewFull">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-play-circle"></i>
                                        <p>Full Video</p>
                                        <small>Select a pool video above</small>
                                    </div>
                                    <div id="previewFullVideo" style="display: none; width: 100%; height: 100%;"></div>
                                </div>
                                <div class="preview-content" id="previewThumbnail">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-image"></i>
                                        <p>Poster Image</p>
                                        <small>Select a pool video above</small>
                                    </div>
                                    <img id="previewThumbnailImg" src="" alt="Poster" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                            
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
                                    <span>Poster</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Settings -->
                    <div class="project-form-section">
                        <h3 class="section-title">
                            <span>Additional Settings</span>
                            <button type="button" class="toggle-section" onclick="toggleSection(this)">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h3>
                        <div class="section-content" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Image Class</label>
                                        <input type="text" class="form-control" name="image_class"
                                               value="<?php echo htmlspecialchars($editing['image_class'] ?? 'bgimage' . (count($projects) + 1)); ?>">
                                        <small class="text-muted">CSS class for background image (e.g., bgimage8)</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" class="form-control" name="order"
                                               value="<?php echo $editing['order'] ?? count($projects); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
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
            <div class="content-card" style="padding:0; overflow:hidden;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border);">
                    <span style="font-size:12px; color:var(--text-3);"><i class="fas fa-grip-vertical" style="margin-right:6px;opacity:.4;"></i>Drag or use arrows to reorder</span>
                    <form method="POST" id="reorderForm">
                        <input type="hidden" name="action" value="reorder">
                        <button type="submit" class="btn-primary btn-sm"><i class="fas fa-save"></i> Save Order</button>
                    </form>
                </div>
                <table class="table" id="projectsTable" style="margin:0;">
                    <thead>
                        <tr>
                            <th style="width:32px;padding-left:16px;"></th>
                            <th style="width:32px;">#</th>
                            <th>Title</th>
                            <th>Dept</th>
                            <th style="width:60px;">Vis</th>
                            <th style="width:60px;"></th>
                            <th style="width:80px;"></th>
                        </tr>
                    </thead>
                    <tbody id="projectsBody">
                        <?php if (empty($projects)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center; color:var(--text-3); padding:40px;">No projects yet. <a href="?action=add">Add your first project</a></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($projects as $idx => $project):
                                $linkedVideo = getVideoById($project['video_id'] ?? '');
                                $displayTitle = !empty($project['title_override']) ? $project['title_override'] : ($linkedVideo['title'] ?? '—');
                                $displaySubtitle = !empty($project['subtitle_override']) ? $project['subtitle_override'] : ($linkedVideo['subtitle'] ?? '');
                            ?>
                                <tr draggable="true" data-id="<?php echo htmlspecialchars($project['id']); ?>">
                                    <td style="padding-left:16px;"><span class="drag-handle"><i class="fas fa-grip-vertical"></i></span></td>
                                    <td class="row-num" style="color:var(--text-3); font-size:12px; font-weight:600;"><?php echo $idx + 1; ?></td>
                                    <td>
                                        <div style="font-weight:500; font-size:13px;"><?php echo htmlspecialchars($displayTitle); ?></div>
                                        <?php if (!empty($displaySubtitle)): ?>
                                            <div style="font-size:11.5px; color:var(--text-3); margin-top:1px;"><?php echo htmlspecialchars($displaySubtitle); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-size:11.5px; color:var(--text-2);"><?php echo htmlspecialchars($project['author']); ?></td>
                                    <td>
                                        <?php if ($project['visible'] ?? true): ?>
                                            <span style="color:var(--green); font-size:11px;"><i class="fas fa-circle" style="font-size:6px; vertical-align:middle; margin-right:4px;"></i>Yes</span>
                                        <?php else: ?>
                                            <span style="color:var(--text-3); font-size:11px;"><i class="fas fa-circle" style="font-size:6px; vertical-align:middle; margin-right:4px;"></i>No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <button type="button" class="move-btn" onclick="moveRow(this,-1)" title="Move up"><i class="fas fa-chevron-up"></i></button>
                                        <button type="button" class="move-btn" onclick="moveRow(this,1)" title="Move down"><i class="fas fa-chevron-down"></i></button>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-sm btn-secondary" style="padding:5px 10px !important;"><i class="fas fa-pen" style="font-size:10px;"></i></a>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this project?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" style="padding:5px 10px !important;"><i class="fas fa-trash" style="font-size:10px;"></i></button>
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
        let selectedVideoData = <?php echo json_encode($editingVideo); ?>;
        
        function selectVideo(el) {
            const id = el.dataset.videoId;
            const title = el.dataset.title;
            const subtitle = el.dataset.subtitle;
            const poster = el.dataset.poster;
            const videoShort = el.dataset.short;
            const videoLong = el.dataset.long;
            
            selectedVideoData = { id, title, subtitle, poster, videoShort, videoLong };
            
            document.getElementById('videoIdInput').value = id;
            
            document.querySelectorAll('.video-picker-item').forEach(item => {
                item.classList.remove('selected');
                item.querySelector('.vpi-check').innerHTML = '';
            });
            el.classList.add('selected');
            el.querySelector('.vpi-check').innerHTML = '<i class="fas fa-check-circle"></i>';
            
            const thumbHtml = poster
                ? '<img class="vps-thumb" src="../roster/' + escapeHtml(poster) + '" alt="">'
                : '<div class="vps-thumb" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-film" style="color:var(--text-3);font-size:24px;"></i></div>';
            
            document.getElementById('selectedVideoDisplay').innerHTML =
                '<div class="video-picker-selected">' +
                    thumbHtml +
                    '<div class="vps-info">' +
                        '<h5>' + escapeHtml(title) + '</h5>' +
                        '<small>' + escapeHtml(subtitle) + '</small><br>' +
                        '<small class="text-muted">ID: ' + escapeHtml(id) + '</small>' +
                    '</div>' +
                    '<div class="vps-actions">' +
                        '<button type="button" class="btn btn-sm btn-outline-danger" onclick="clearVideoSelection()">' +
                            '<i class="fas fa-times"></i> Remove' +
                        '</button>' +
                    '</div>' +
                '</div>';
            
            document.getElementById('titleOverrideInput').placeholder = title;
            document.getElementById('subtitleOverrideInput').placeholder = subtitle;
            
            updatePreview();
        }
        
        function clearVideoSelection() {
            selectedVideoData = null;
            document.getElementById('videoIdInput').value = '';
            document.getElementById('selectedVideoDisplay').innerHTML =
                '<div class="video-picker-selected empty">' +
                    '<span><i class="fas fa-film"></i> No video selected &mdash; pick one below</span>' +
                '</div>';
            document.querySelectorAll('.video-picker-item').forEach(item => {
                item.classList.remove('selected');
                item.querySelector('.vpi-check').innerHTML = '';
            });
            document.getElementById('titleOverrideInput').placeholder = 'Pool video title';
            document.getElementById('subtitleOverrideInput').placeholder = 'Pool video subtitle';
            updatePreview();
        }
        
        function filterVideoPicker() {
            const query = document.getElementById('videoSearchInput').value.toLowerCase();
            document.querySelectorAll('.video-picker-item').forEach(item => {
                const title = (item.dataset.title || '').toLowerCase();
                const subtitle = (item.dataset.subtitle || '').toLowerCase();
                item.style.display = (title.includes(query) || subtitle.includes(query)) ? '' : 'none';
            });
        }
        
        function switchPreview(view) {
            document.querySelectorAll('.preview-toggle-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-view') === view);
            });
            document.querySelectorAll('.preview-content').forEach(c => c.classList.remove('active'));
            
            if (view === 'thumbnail') {
                document.getElementById('previewThumbnail').classList.add('active');
            } else if (view === 'video') {
                document.getElementById('previewVideo').classList.add('active');
                const videoEl = document.getElementById('previewVideoElement');
                if (videoEl.src) videoEl.play().catch(() => {});
            } else if (view === 'full') {
                document.getElementById('previewFull').classList.add('active');
            }
        }
        
        function updatePreview() {
            const videoShort = selectedVideoData ? (selectedVideoData.videoShort || '') : '';
            const videoLong = selectedVideoData ? (selectedVideoData.videoLong || '') : '';
            const poster = selectedVideoData ? (selectedVideoData.poster || '') : '';
            
            // Poster / thumbnail
            const thumbnailImg = document.getElementById('previewThumbnailImg');
            const thumbnailPlaceholder = document.querySelector('#previewThumbnail .preview-placeholder');
            if (poster) {
                thumbnailImg.src = '../roster/' + poster;
                thumbnailImg.style.display = 'block';
                thumbnailPlaceholder.style.display = 'none';
                updateQC('thumbnail', true);
            } else {
                thumbnailImg.src = '';
                thumbnailImg.style.display = 'none';
                thumbnailPlaceholder.style.display = 'flex';
                updateQC('thumbnail', false);
            }
            
            // Short video preview
            const videoEl = document.getElementById('previewVideoElement');
            const videoPlaceholder = document.querySelector('#previewVideo .preview-placeholder');
            if (videoShort) {
                videoEl.src = '../roster/' + videoShort;
                videoEl.style.display = 'block';
                videoPlaceholder.style.display = 'none';
                updateQC('video', true);
                if (document.querySelector('.preview-toggle-btn[data-view="video"]').classList.contains('active')) {
                    videoEl.play().catch(() => {});
                }
            } else {
                videoEl.src = '';
                videoEl.style.display = 'none';
                videoPlaceholder.style.display = 'flex';
                updateQC('video', false);
            }
            
            // Full video preview
            const fullVideoDiv = document.getElementById('previewFullVideo');
            const fullPlaceholder = document.querySelector('#previewFull .preview-placeholder');
            if (videoLong) {
                fullPlaceholder.style.display = 'none';
                fullVideoDiv.style.display = 'block';
                if (videoLong.includes('gosimian.com') || videoLong.startsWith('http')) {
                    if (!fullVideoDiv.querySelector('iframe')) {
                        const iframe = document.createElement('iframe');
                        iframe.src = videoLong;
                        iframe.style.cssText = 'width:100%;height:100%;border:none;';
                        iframe.setAttribute('allowFullScreen', '');
                        fullVideoDiv.innerHTML = '';
                        fullVideoDiv.appendChild(iframe);
                    } else {
                        fullVideoDiv.querySelector('iframe').src = videoLong;
                    }
                } else {
                    fullVideoDiv.innerHTML = '<video controls style="width:100%;height:100%;object-fit:cover;" src="../roster/' + videoLong + '"></video>';
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
            qcItem.classList.toggle('valid', isValid);
            qcItem.classList.toggle('invalid', !isValid);
            qcItem.querySelector('i').className = isValid ? 'fas fa-check-circle' : 'fas fa-times-circle';
        }
        
        function toggleSection(btn) {
            const section = btn.closest('.project-form-section');
            const content = section.querySelector('.section-content');
            const icon = btn.querySelector('i');
            const hidden = content.style.display === 'none';
            content.style.display = hidden ? 'block' : 'none';
            icon.className = hidden ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
            btn.classList.toggle('active', hidden);
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
            initDragReorder();
        });

        // Drag-and-drop reorder
        function initDragReorder() {
            const tbody = document.getElementById('projectsBody');
            if (!tbody) return;
            let dragRow = null;

            tbody.querySelectorAll('tr[draggable]').forEach(row => {
                row.addEventListener('dragstart', e => {
                    dragRow = row;
                    row.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });
                row.addEventListener('dragend', () => {
                    row.classList.remove('dragging');
                    tbody.querySelectorAll('tr').forEach(r => r.classList.remove('drag-over'));
                    dragRow = null;
                    renumberRows();
                });
                row.addEventListener('dragover', e => {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    tbody.querySelectorAll('tr').forEach(r => r.classList.remove('drag-over'));
                    if (row !== dragRow) row.classList.add('drag-over');
                });
                row.addEventListener('drop', e => {
                    e.preventDefault();
                    if (dragRow && row !== dragRow) {
                        const rows = [...tbody.querySelectorAll('tr[draggable]')];
                        const fromIdx = rows.indexOf(dragRow);
                        const toIdx = rows.indexOf(row);
                        if (fromIdx < toIdx) {
                            row.parentNode.insertBefore(dragRow, row.nextSibling);
                        } else {
                            row.parentNode.insertBefore(dragRow, row);
                        }
                        renumberRows();
                    }
                });
            });
        }

        function moveRow(btn, dir) {
            const row = btn.closest('tr');
            const tbody = row.parentNode;
            const rows = [...tbody.querySelectorAll('tr[draggable]')];
            const idx = rows.indexOf(row);
            if (dir === -1 && idx > 0) {
                tbody.insertBefore(row, rows[idx - 1]);
            } else if (dir === 1 && idx < rows.length - 1) {
                tbody.insertBefore(rows[idx + 1], row);
            }
            renumberRows();
        }

        function renumberRows() {
            const tbody = document.getElementById('projectsBody');
            const form = document.getElementById('reorderForm');
            form.querySelectorAll('input[name="order_ids[]"]').forEach(i => i.remove());
            tbody.querySelectorAll('tr[draggable]').forEach((row, i) => {
                row.querySelector('.row-num').textContent = i + 1;
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'order_ids[]';
                hidden.value = row.dataset.id;
                form.appendChild(hidden);
            });
        }

        // Initialize hidden inputs on page load
        document.addEventListener('DOMContentLoaded', renumberRows);
    </script>
</body>
</html>
