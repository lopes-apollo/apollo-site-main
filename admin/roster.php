<?php
require_once 'config.php';
requireLogin();

$artists = getArtists();
$roster = getRoster();

// Auto-migrate: If roster is empty but artists have categories, migrate them
if (empty(array_filter($roster)) && !empty($artists)) {
    $has_categories = false;
    foreach ($artists as $artist) {
        if (!empty($artist['category']) && in_array($artist['category'], ROSTER_SECTIONS)) {
            $has_categories = true;
            break;
        }
    }
    
    if ($has_categories) {
        // Migrate artists based on their category tags
        $migrated_roster = [
            'EDIT' => [],
            'COLOR' => [],
            'SOUND' => [],
            'VFX' => []
        ];
        
        // Group artists by category and sort alphabetically
        foreach ($artists as $artist) {
            if (!empty($artist['category']) && in_array($artist['category'], ROSTER_SECTIONS)) {
                $category = $artist['category'];
                if ($artist['visible'] ?? true) {
                    $migrated_roster[$category][] = $artist['id'];
                }
            }
        }
        
        // Sort each category alphabetically by artist name
        foreach (ROSTER_SECTIONS as $section) {
            usort($migrated_roster[$section], function($a, $b) use ($artists) {
                $artist_a = null;
                $artist_b = null;
                foreach ($artists as $artist) {
                    if ($artist['id'] === $a) $artist_a = $artist;
                    if ($artist['id'] === $b) $artist_b = $artist;
                }
                $name_a = $artist_a ? ($artist_a['name'] ?? '') : '';
                $name_b = $artist_b ? ($artist_b['name'] ?? '') : '';
                return strcasecmp($name_a, $name_b);
            });
        }
        
        saveRoster($migrated_roster);
        $roster = $migrated_roster;
        $message = '<div class="alert alert-success"><i class="fas fa-info-circle"></i> Migrated existing artists to roster assignments based on their category tags.</div>';
    }
}

$pending = getPendingChanges();
$pending_roster = $pending['roster'] ?? null;
$has_pending = !empty($pending_roster);
$message = $message ?? '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_roster') {
        // Update roster assignments
        $new_roster = [
            'EDIT' => [],
            'COLOR' => [],
            'SOUND' => [],
            'VFX' => []
        ];
        
        foreach (ROSTER_SECTIONS as $section) {
            if (isset($_POST['roster'][$section]) && is_array($_POST['roster'][$section])) {
                $new_roster[$section] = $_POST['roster'][$section];
            }
        }
        
        // Sort each section alphabetically by artist name
        foreach (ROSTER_SECTIONS as $section) {
            usort($new_roster[$section], function($a, $b) use ($artists) {
                $artist_a = null;
                $artist_b = null;
                foreach ($artists as $artist) {
                    if ($artist['id'] === $a) $artist_a = $artist;
                    if ($artist['id'] === $b) $artist_b = $artist;
                }
                $name_a = $artist_a ? ($artist_a['name'] ?? '') : '';
                $name_b = $artist_b ? ($artist_b['name'] ?? '') : '';
                return strcasecmp($name_a, $name_b);
            });
        }
        
        // Save to pending changes instead of directly
        savePendingChanges(['roster' => $new_roster]);
        $roster = $new_roster;
        $pending_roster = $new_roster;
        $has_pending = true;
        $message = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Changes saved to pending!</strong> Click "Save to Next Sync" below to prepare these changes for the next website sync.</div>';
    } elseif ($action === 'save_to_sync') {
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>Changes saved for next sync!</strong> Go to <a href="sync.php">Sync to Website</a> to apply these changes.</div>';
    }
    
    // Refresh data
    $pending = getPendingChanges();
    $pending_roster = $pending['roster'] ?? null;
    $has_pending = !empty($pending_roster);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roster - Apollo CMS</title>
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
        
        .roster-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .roster-box {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 400px;
        }
        .roster-box-header {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        .roster-box-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .roster-dropdown {
            margin-bottom: 15px;
        }
        .roster-dropdown select {
            width: 100%;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 10px;
            border-radius: 0;
        }
        .artist-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
            max-height: 500px;
        }
        .artist-list-item {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            padding: 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .artist-list-item:hover {
            background: var(--bg-hover);
            border-color: var(--accent);
        }
        .artist-info {
            flex-grow: 1;
            min-width: 0;
        }
        .artist-info strong {
            color: var(--text-primary);
            display: block;
            font-size: 13px;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .artist-info small {
            color: var(--text-muted);
            font-size: 11px;
        }
        .artist-remove {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 5px 10px;
            cursor: pointer;
            font-size: 11px;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .artist-remove:hover {
            background: var(--danger);
            color: white;
        }
        .empty-message {
            color: var(--text-muted);
            text-align: center;
            padding: 20px;
            font-size: 13px;
        }
        @media (max-width: 1200px) {
            .roster-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .roster-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-list"></i> Roster</h1>
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
        
        <div class="content-card">
            <h2>Manage Roster Assignments</h2>
            <p class="text-muted mb-4">
                Assign artists to roster sections for website display. Artists must be created in the <a href="artists.php">Artists</a> tab first. 
                You can assign the same artist to multiple roster sections if needed.
            </p>
            
            <form method="POST" id="rosterForm">
                <input type="hidden" name="action" value="update_roster">
                
                <div class="roster-grid">
                    <?php foreach (ROSTER_SECTIONS as $section): 
                        $section_artist_ids = $roster[$section] ?? [];
                        $section_artists = [];
                        foreach ($section_artist_ids as $artist_id) {
                            foreach ($artists as $artist) {
                                if ($artist['id'] === $artist_id) {
                                    $section_artists[] = $artist;
                                    break;
                                }
                            }
                        }
                        // Sort alphabetically by name
                        usort($section_artists, function($a, $b) {
                            return strcasecmp($a['name'], $b['name']);
                        });
                    ?>
                        <div class="roster-box">
                            <div class="roster-box-header">
                                <h3><?php echo ROSTER_LABELS[$section]; ?></h3>
                            </div>
                            
                            <div class="roster-dropdown">
                                <select id="select_<?php echo $section; ?>" onchange="addArtistToRoster('<?php echo $section; ?>', this.value)">
                                    <option value="">Add artist...</option>
                                    <?php foreach ($artists as $artist): ?>
                                        <?php if (!in_array($artist['id'], $section_artist_ids)): ?>
                                            <option value="<?php echo $artist['id']; ?>">
                                                <?php echo htmlspecialchars($artist['name']); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="roster-artists" id="roster_<?php echo $section; ?>">
                                <ul class="artist-list">
                                    <?php if (empty($section_artists)): ?>
                                        <li class="empty-message">
                                            No artists assigned
                                        </li>
                                    <?php else: ?>
                                        <?php foreach ($section_artists as $idx => $artist): ?>
                                            <li class="artist-list-item" data-artist-id="<?php echo $artist['id']; ?>">
                                                <input type="hidden" name="roster[<?php echo $section; ?>][]" value="<?php echo $artist['id']; ?>">
                                                <div class="artist-info">
                                                    <strong><?php echo htmlspecialchars($artist['name']); ?></strong>
                                                    <small><?php echo count($artist['videos'] ?? []); ?> videos</small>
                                                </div>
                                                <button type="button" 
                                                        class="artist-remove" 
                                                        onclick="removeArtistFromRoster('<?php echo $section; ?>', '<?php echo $artist['id']; ?>')"
                                                        title="Remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="form-actions mt-4">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Roster Assignments
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Store artist data for JavaScript access
        const artistData = <?php echo json_encode(array_column($artists, null, 'id')); ?>;
        function addArtistToRoster(section, artistId) {
            if (!artistId) return;
            
            const select = document.getElementById('select_' + section);
            const selectedOption = select.options[select.selectedIndex];
            const artistName = selectedOption.text;
            
            const rosterDiv = document.getElementById('roster_' + section);
            let list = rosterDiv.querySelector('.artist-list');
            
            if (!list) {
                list = document.createElement('ul');
                list.className = 'artist-list';
                rosterDiv.innerHTML = '';
                rosterDiv.appendChild(list);
            }
            
            // Remove "No artists" message if present
            const emptyMsg = list.querySelector('.empty-message');
            if (emptyMsg) {
                emptyMsg.remove();
            }
            
            // Get artist video count from stored data
            const videoCount = artistData[artistId] ? (artistData[artistId].videos ? artistData[artistId].videos.length : 0) : 0;
            
            // Create new list item
            const li = document.createElement('li');
            li.className = 'artist-list-item';
            li.setAttribute('data-artist-id', artistId);
            li.innerHTML = `
                <input type="hidden" name="roster[${section}][]" value="${artistId}">
                <div class="artist-info">
                    <strong>${artistName}</strong>
                    <small>${videoCount} videos</small>
                </div>
                <button type="button" 
                        class="artist-remove" 
                        onclick="removeArtistFromRoster('${section}', '${artistId}')"
                        title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            list.appendChild(li);
            
            // Sort alphabetically after adding
            sortArtistsAlphabetically(section);
            
            // Remove from select
            select.remove(select.selectedIndex);
            select.value = '';
        }
        
        function removeArtistFromRoster(section, artistId) {
            const rosterDiv = document.getElementById('roster_' + section);
            const list = rosterDiv.querySelector('.artist-list');
            const item = list.querySelector(`[data-artist-id="${artistId}"]`);
            
            if (!item) return;
            
            // Get artist name for re-adding to select
            const artistName = item.querySelector('strong').textContent;
            
            item.remove();
            
            // Re-add to select dropdown
            const select = document.getElementById('select_' + section);
            const option = document.createElement('option');
            option.value = artistId;
            option.textContent = artistName;
            select.appendChild(option);
            
            // Show empty message if no artists left
            if (list.querySelectorAll('.artist-list-item').length === 0) {
                list.innerHTML = '<li class="empty-message">No artists assigned</li>';
            }
        }
        
        function sortArtistsAlphabetically(section) {
            const list = document.getElementById('roster_' + section).querySelector('.artist-list');
            const items = Array.from(list.querySelectorAll('.artist-list-item'));
            
            // Sort by artist name
            items.sort((a, b) => {
                const nameA = a.querySelector('strong').textContent.trim().toLowerCase();
                const nameB = b.querySelector('strong').textContent.trim().toLowerCase();
                return nameA.localeCompare(nameB);
            });
            
            // Clear and re-append in sorted order
            list.innerHTML = '';
            items.forEach(item => list.appendChild(item));
        }
    </script>
</body>
</html>
