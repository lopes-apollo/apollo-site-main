<?php
require_once 'config.php';
requireLogin();

$artists = getArtists();
$allVideos = getVideos();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'save_artist') {
        $id = !empty($_POST['id']) ? $_POST['id'] : uniqid('artist_');
        $isNew = true;
        
        $video_ids = [];
        if (isset($_POST['video_ids']) && is_array($_POST['video_ids'])) {
            $video_ids = array_values(array_filter($_POST['video_ids'], function($vid) {
                return !empty($vid);
            }));
        }
        
        $artist = [
            'id' => $id,
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'category' => $_POST['category'] ?? '',
            'video_ids' => $video_ids,
            'visible' => isset($_POST['visible'])
        ];
        
        foreach ($artists as $key => $a) {
            if ($a['id'] === $id) {
                $artists[$key] = $artist;
                $isNew = false;
                break;
            }
        }
        if ($isNew) {
            $artists[] = $artist;
        }
        
        usort($artists, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        
        saveArtists($artists);
        
        // Auto-add to roster section if category is set and artist is visible
        if (!empty($artist['category']) && ($artist['visible'] ?? true)) {
            $roster = getRoster();
            $cat = $artist['category'];
            if (isset($roster[$cat]) && !in_array($id, $roster[$cat])) {
                $roster[$cat][] = $id;
                saveRoster($roster);
            }
        }
        
        savePendingChanges(['artists' => $artists]);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Artist saved!</strong> ' . htmlspecialchars($artist['name']) . ' has been saved successfully.</div>';
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $deletedName = '';
        foreach ($artists as $a) {
            if ($a['id'] === $id) { $deletedName = $a['name']; break; }
        }
        $artists = array_values(array_filter($artists, function($a) use ($id) {
            return $a['id'] !== $id;
        }));
        
        saveArtists($artists);
        
        // Remove from all roster sections
        $roster = getRoster();
        $rosterChanged = false;
        foreach ($roster as $cat => &$ids) {
            if (($pos = array_search($id, $ids)) !== false) {
                array_splice($ids, $pos, 1);
                $rosterChanged = true;
            }
        }
        unset($ids);
        if ($rosterChanged) {
            saveRoster($roster);
        }
        
        savePendingChanges(['artists' => $artists]);
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Deleted!</strong> ' . htmlspecialchars($deletedName) . ' has been removed.</div>';
    }
    
    // Re-read fresh data
    clearCache();
    $artists = getArtists();
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

$linkedVideos = [];
if ($editing) {
    $linkedVideos = getVideosForArtist($editing);
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
        .linked-videos-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .linked-video-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-bottom: none;
            transition: background 0.15s ease, border-color 0.15s ease;
            cursor: grab;
            user-select: none;
        }
        .linked-video-item:last-child {
            border-bottom: 1px solid var(--border-color);
        }
        .linked-video-item:hover {
            background: var(--bg-hover);
        }
        .linked-video-item.dragging {
            opacity: 0.4;
            background: var(--bg-tertiary);
        }
        .linked-video-item.drag-over {
            border-top: 2px solid var(--accent);
        }
        .linked-video-thumb {
            width: 80px;
            height: 45px;
            object-fit: cover;
            background: #000;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
        }
        .linked-video-thumb-placeholder {
            width: 80px;
            height: 45px;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 16px;
        }
        .linked-video-info {
            flex: 1;
            min-width: 0;
        }
        .linked-video-title {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .linked-video-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .linked-video-id {
            font-size: 11px;
            color: var(--text-muted);
            font-family: monospace;
        }
        .linked-video-grip {
            color: var(--text-muted);
            font-size: 14px;
            cursor: grab;
            padding: 4px;
            flex-shrink: 0;
        }
        .linked-video-grip:active { cursor: grabbing; }
        .linked-video-remove {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px 8px;
            font-size: 13px;
            transition: color 0.15s;
            flex-shrink: 0;
        }
        .linked-video-remove:hover { color: var(--danger); }
        .linked-video-order {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }
        .linked-videos-empty {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
            background: var(--bg-secondary);
            border: 1px dashed var(--border-color);
        }
        .linked-videos-empty i { font-size: 28px; margin-bottom: 8px; display: block; }

        /* Video Picker */
        .video-picker-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            font-size: 13px;
            transition: all 0.15s;
            border-radius: 0px;
        }
        .video-picker-toggle:hover {
            background: var(--bg-hover);
            border-color: var(--accent);
        }
        .video-picker-panel {
            display: none;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            margin-top: 10px;
            max-height: 500px;
            overflow: hidden;
            flex-direction: column;
        }
        .video-picker-panel.open {
            display: flex;
        }
        .video-picker-search {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            background: var(--bg-secondary);
            z-index: 2;
        }
        .video-picker-search input {
            width: 100%;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 0px;
            outline: none;
        }
        .video-picker-search input:focus {
            border-color: var(--accent);
        }
        .video-picker-search input::placeholder {
            color: var(--text-muted);
        }
        .video-picker-results {
            overflow-y: auto;
            max-height: 420px;
            padding: 4px 0;
        }
        .video-picker-results::-webkit-scrollbar { width: 6px; }
        .video-picker-results::-webkit-scrollbar-track { background: var(--bg-secondary); }
        .video-picker-results::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        .video-picker-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 14px;
            cursor: pointer;
            transition: background 0.1s;
        }
        .video-picker-item:hover {
            background: var(--bg-hover);
        }
        .video-picker-item.already-linked {
            opacity: 0.4;
            pointer-events: none;
        }
        .video-picker-item-thumb {
            width: 72px;
            height: 40px;
            object-fit: cover;
            background: #000;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
        }
        .video-picker-item-thumb-placeholder {
            width: 72px;
            height: 40px;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 14px;
        }
        .video-picker-item-info {
            flex: 1;
            min-width: 0;
        }
        .video-picker-item-title {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }
        .video-picker-item-sub {
            font-size: 12px;
            color: var(--text-secondary);
        }
        .video-picker-item-badge {
            font-size: 11px;
            color: var(--text-muted);
            background: var(--bg-tertiary);
            padding: 2px 8px;
            border: 1px solid var(--border-color);
            flex-shrink: 0;
        }
        .video-picker-item .add-icon {
            color: var(--success);
            font-size: 16px;
            flex-shrink: 0;
        }
        .video-picker-empty {
            padding: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }
        .video-picker-count {
            padding: 8px 14px;
            font-size: 12px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-tertiary);
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
                                <small class="text-muted">Category tag (Editor, Colorist, Sound Designer, or VFX Artist). Roster assignments are managed separately in the Roster tab.</small>
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
                            <h3 class="mb-0">Linked Videos</h3>
                            <p class="text-muted mb-0">Drag to reorder. Videos are managed in the <a href="video-pool.php" target="_blank">Video Pool</a>.</p>
                        </div>
                        <button type="button" class="video-picker-toggle" onclick="toggleVideoPicker()">
                            <i class="fas fa-plus"></i> Link Video
                        </button>
                    </div>
                    
                    <!-- Video Picker Panel -->
                    <div class="video-picker-panel" id="videoPickerPanel">
                        <div class="video-picker-search">
                            <input type="text" id="videoPickerSearch" placeholder="Search videos by title or subtitle..." oninput="filterVideoPicker()">
                        </div>
                        <div class="video-picker-count" id="videoPickerCount"></div>
                        <div class="video-picker-results" id="videoPickerResults"></div>
                    </div>
                    
                    <!-- Linked Videos Container -->
                    <div id="linkedVideosContainer">
                        <?php if (empty($linkedVideos)): ?>
                            <div class="linked-videos-empty" id="emptyState">
                                <i class="fas fa-link"></i>
                                <p>No videos linked yet. Click "Link Video" to add videos from the pool.</p>
                            </div>
                        <?php else: ?>
                            <div class="linked-videos-list" id="linkedVideosList">
                                <?php foreach ($linkedVideos as $idx => $video): ?>
                                    <div class="linked-video-item" draggable="true" data-video-id="<?php echo htmlspecialchars($video['id']); ?>">
                                        <input type="hidden" name="video_ids[]" value="<?php echo htmlspecialchars($video['id']); ?>">
                                        <span class="linked-video-order"><?php echo $idx + 1; ?></span>
                                        <i class="fas fa-grip-vertical linked-video-grip"></i>
                                        <?php if (!empty($video['poster'])): ?>
                                            <img class="linked-video-thumb" src="../roster/<?php echo htmlspecialchars($video['poster']); ?>" alt="" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="linked-video-thumb-placeholder" style="display:none;"><i class="fas fa-video"></i></div>
                                        <?php else: ?>
                                            <div class="linked-video-thumb-placeholder"><i class="fas fa-video"></i></div>
                                        <?php endif; ?>
                                        <div class="linked-video-info">
                                            <div class="linked-video-title"><?php echo htmlspecialchars($video['title'] ?? 'Untitled'); ?></div>
                                            <?php if (!empty($video['subtitle'])): ?>
                                                <div class="linked-video-subtitle"><?php echo htmlspecialchars($video['subtitle']); ?></div>
                                            <?php endif; ?>
                                            <div class="linked-video-id"><?php echo htmlspecialchars($video['id']); ?></div>
                                        </div>
                                        <button type="button" class="linked-video-remove" onclick="unlinkVideo(this)" title="Remove from artist">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
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
                                        <span class="badge bg-info"><?php echo count($artist['video_ids'] ?? []); ?> videos</span>
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
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this artist?');">
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
        const ALL_VIDEOS = <?php echo json_encode(array_values($allVideos), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES); ?>;
        
        function updateSlug(name) {
            const slugInput = document.querySelector('input[name="slug"]');
            if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                slugInput.value = name.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.dataset.autoGenerated = 'true';
            }
        }
        
        // --- Video Picker ---
        function toggleVideoPicker() {
            const panel = document.getElementById('videoPickerPanel');
            const isOpen = panel.classList.contains('open');
            if (isOpen) {
                panel.classList.remove('open');
            } else {
                panel.classList.add('open');
                document.getElementById('videoPickerSearch').value = '';
                document.getElementById('videoPickerSearch').focus();
                renderVideoPicker();
            }
        }
        
        function getLinkedIds() {
            const inputs = document.querySelectorAll('input[name="video_ids[]"]');
            return Array.from(inputs).map(i => i.value);
        }
        
        function renderVideoPicker(filter) {
            const results = document.getElementById('videoPickerResults');
            const countEl = document.getElementById('videoPickerCount');
            const linkedIds = getLinkedIds();
            const q = (filter || '').toLowerCase().trim();
            
            let filtered = ALL_VIDEOS;
            if (q) {
                filtered = ALL_VIDEOS.filter(v => {
                    const title = (v.title || '').toLowerCase();
                    const subtitle = (v.subtitle || '').toLowerCase();
                    const id = (v.id || '').toLowerCase();
                    return title.includes(q) || subtitle.includes(q) || id.includes(q);
                });
            }
            
            countEl.textContent = filtered.length + ' video' + (filtered.length !== 1 ? 's' : '') + ' in pool' + (q ? ' (filtered)' : '');
            
            if (filtered.length === 0) {
                results.innerHTML = '<div class="video-picker-empty">No videos found.</div>';
                return;
            }
            
            let html = '';
            filtered.forEach(v => {
                const isLinked = linkedIds.includes(v.id);
                const thumb = v.poster
                    ? '<img class="video-picker-item-thumb" src="../roster/' + escapeAttr(v.poster) + '" alt="" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">' +
                      '<div class="video-picker-item-thumb-placeholder" style="display:none;"><i class="fas fa-video"></i></div>'
                    : '<div class="video-picker-item-thumb-placeholder"><i class="fas fa-video"></i></div>';
                
                html += '<div class="video-picker-item' + (isLinked ? ' already-linked' : '') + '" onclick="linkVideo(\'' + escapeAttr(v.id) + '\')">';
                html += thumb;
                html += '<div class="video-picker-item-info">';
                html += '<div class="video-picker-item-title">' + escapeHtml(v.title || 'Untitled') + '</div>';
                if (v.subtitle) {
                    html += '<div class="video-picker-item-sub">' + escapeHtml(v.subtitle) + '</div>';
                }
                html += '</div>';
                if (isLinked) {
                    html += '<span class="video-picker-item-badge">Linked</span>';
                } else {
                    html += '<span class="add-icon"><i class="fas fa-plus-circle"></i></span>';
                }
                html += '</div>';
            });
            
            results.innerHTML = html;
        }
        
        function filterVideoPicker() {
            const q = document.getElementById('videoPickerSearch').value;
            renderVideoPicker(q);
        }
        
        function linkVideo(videoId) {
            const linkedIds = getLinkedIds();
            if (linkedIds.includes(videoId)) return;
            
            const video = ALL_VIDEOS.find(v => v.id === videoId);
            if (!video) return;
            
            ensureListContainer();
            const list = document.getElementById('linkedVideosList');
            const order = list.querySelectorAll('.linked-video-item').length + 1;
            
            const thumb = video.poster
                ? '<img class="linked-video-thumb" src="../roster/' + escapeAttr(video.poster) + '" alt="" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">' +
                  '<div class="linked-video-thumb-placeholder" style="display:none;"><i class="fas fa-video"></i></div>'
                : '<div class="linked-video-thumb-placeholder"><i class="fas fa-video"></i></div>';
            
            const item = document.createElement('div');
            item.className = 'linked-video-item';
            item.draggable = true;
            item.dataset.videoId = video.id;
            item.innerHTML = '<input type="hidden" name="video_ids[]" value="' + escapeAttr(video.id) + '">' +
                '<span class="linked-video-order">' + order + '</span>' +
                '<i class="fas fa-grip-vertical linked-video-grip"></i>' +
                thumb +
                '<div class="linked-video-info">' +
                    '<div class="linked-video-title">' + escapeHtml(video.title || 'Untitled') + '</div>' +
                    (video.subtitle ? '<div class="linked-video-subtitle">' + escapeHtml(video.subtitle) + '</div>' : '') +
                    '<div class="linked-video-id">' + escapeHtml(video.id) + '</div>' +
                '</div>' +
                '<button type="button" class="linked-video-remove" onclick="unlinkVideo(this)" title="Remove from artist">' +
                    '<i class="fas fa-times"></i>' +
                '</button>';
            
            list.appendChild(item);
            initDragItem(item);
            renderVideoPicker(document.getElementById('videoPickerSearch').value);
        }
        
        function ensureListContainer() {
            const container = document.getElementById('linkedVideosContainer');
            const empty = document.getElementById('emptyState');
            if (empty) empty.remove();
            
            if (!document.getElementById('linkedVideosList')) {
                const list = document.createElement('div');
                list.className = 'linked-videos-list';
                list.id = 'linkedVideosList';
                container.appendChild(list);
            }
        }
        
        function unlinkVideo(btn) {
            const item = btn.closest('.linked-video-item');
            if (!item) return;
            item.remove();
            
            renumberLinkedVideos();
            
            const list = document.getElementById('linkedVideosList');
            if (list && list.querySelectorAll('.linked-video-item').length === 0) {
                list.remove();
                const container = document.getElementById('linkedVideosContainer');
                container.innerHTML = '<div class="linked-videos-empty" id="emptyState">' +
                    '<i class="fas fa-link"></i>' +
                    '<p>No videos linked yet. Click "Link Video" to add videos from the pool.</p></div>';
            }
            
            renderVideoPicker(document.getElementById('videoPickerSearch')?.value || '');
        }
        
        function renumberLinkedVideos() {
            const list = document.getElementById('linkedVideosList');
            if (!list) return;
            list.querySelectorAll('.linked-video-item').forEach((item, i) => {
                const orderSpan = item.querySelector('.linked-video-order');
                if (orderSpan) orderSpan.textContent = i + 1;
            });
        }
        
        // --- Drag and Drop ---
        let dragSrcEl = null;
        
        function initDragItem(item) {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('dragenter', handleDragEnter);
            item.addEventListener('dragleave', handleDragLeave);
            item.addEventListener('drop', handleDrop);
            item.addEventListener('dragend', handleDragEnd);
        }
        
        function handleDragStart(e) {
            dragSrcEl = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.dataset.videoId);
        }
        
        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }
        
        function handleDragEnter(e) {
            e.preventDefault();
            if (this !== dragSrcEl) {
                this.classList.add('drag-over');
            }
        }
        
        function handleDragLeave(e) {
            this.classList.remove('drag-over');
        }
        
        function handleDrop(e) {
            e.stopPropagation();
            e.preventDefault();
            this.classList.remove('drag-over');
            
            if (dragSrcEl && dragSrcEl !== this) {
                const list = this.parentNode;
                const allItems = Array.from(list.querySelectorAll('.linked-video-item'));
                const fromIdx = allItems.indexOf(dragSrcEl);
                const toIdx = allItems.indexOf(this);
                
                if (fromIdx < toIdx) {
                    list.insertBefore(dragSrcEl, this.nextSibling);
                } else {
                    list.insertBefore(dragSrcEl, this);
                }
                renumberLinkedVideos();
            }
        }
        
        function handleDragEnd(e) {
            this.classList.remove('dragging');
            document.querySelectorAll('.linked-video-item').forEach(item => {
                item.classList.remove('drag-over');
            });
            dragSrcEl = null;
        }
        
        // --- Utilities ---
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }
        
        function escapeAttr(text) {
            return (text || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }
        
        // Init drag on existing items
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.linked-video-item').forEach(initDragItem);
        });
    </script>
</body>
</html>
