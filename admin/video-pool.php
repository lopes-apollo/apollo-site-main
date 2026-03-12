<?php
require_once 'config.php';
requireLogin();

$message = '';
$videos = getVideos();
$artists = getArtists();
$roster = getRoster();
$landing = getLandingPageProjects();

// Group artists by department for the assignment UI
$artists_by_dept = ['EDIT' => [], 'COLOR' => [], 'SOUND' => [], 'VFX' => []];
foreach ($artists as $a) {
    $dept = $a['category'] ?? '';
    if (isset($artists_by_dept[$dept])) {
        $artists_by_dept[$dept][] = $a;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_video') {
        $new_id = 'vid_' . bin2hex(random_bytes(6));
        $new_video = [
            'id' => $new_id,
            'title' => trim($_POST['title'] ?? ''),
            'subtitle' => trim($_POST['subtitle'] ?? ''),
            'videoShort' => trim($_POST['videoShort'] ?? ''),
            'videoLong' => trim($_POST['videoLong'] ?? ''),
            'poster' => trim($_POST['poster'] ?? ''),
            'hasCredit' => isset($_POST['hasCredit']),
            'credits' => $_POST['credits'] ?? '',
            'previewImages' => ['', '', '', '', '', ''],
            'tags' => $_POST['tags'] ?? [],
            'created_at' => date('Y-m-d')
        ];
        if ($new_video['title']) {
            $videos[] = $new_video;
            saveVideos($videos);

            // Handle artist assignments
            $selected_artists = $_POST['artist_ids'] ?? [];
            if (!empty($selected_artists)) {
                $artists = getArtists();
                foreach ($artists as &$a) {
                    if (in_array($a['id'], $selected_artists)) {
                        if (!in_array($new_id, $a['video_ids'] ?? [])) {
                            $a['video_ids'][] = $new_id;
                        }
                    }
                }
                unset($a);
                saveArtists($artists);
                savePendingChanges(['artists' => $artists]);
            }

            // Handle landing page
            if (isset($_POST['feature_landing'])) {
                $lp = addVideoToLanding(
                    $new_id,
                    trim($_POST['landing_title'] ?? ''),
                    trim($_POST['landing_subtitle'] ?? ''),
                    implode(',', $_POST['tags'] ?? [])
                );
                saveLandingPageProjects($lp);
                savePendingChanges(['landing_page' => $lp]);
            }

            clearCache();
            $videos = getVideos();
            $artists = getArtists();
            $landing = getLandingPageProjects();
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Video added successfully.</div>';
        }
    }

    if ($action === 'edit_video') {
        $video_id = $_POST['video_id'] ?? '';
        foreach ($videos as $key => $video) {
            if ($video['id'] === $video_id) {
                $videos[$key]['title'] = trim($_POST['title'] ?? $video['title']);
                $videos[$key]['subtitle'] = trim($_POST['subtitle'] ?? $video['subtitle']);
                $videos[$key]['videoShort'] = trim($_POST['videoShort'] ?? $video['videoShort']);
                $videos[$key]['videoLong'] = trim($_POST['videoLong'] ?? $video['videoLong']);
                $videos[$key]['poster'] = trim($_POST['poster'] ?? $video['poster']);
                $videos[$key]['hasCredit'] = isset($_POST['hasCredit']);
                $videos[$key]['credits'] = $_POST['credits'] ?? $video['credits'];
                $videos[$key]['tags'] = $_POST['tags'] ?? [];
                break;
            }
        }
        saveVideos($videos);

        // Update artist assignments
        $selected_artists = $_POST['artist_ids'] ?? [];
        $artists = getArtists();
        $changed = false;
        foreach ($artists as &$a) {
            $has_video = in_array($video_id, $a['video_ids'] ?? []);
            $should_have = in_array($a['id'], $selected_artists);
            if ($should_have && !$has_video) {
                $a['video_ids'][] = $video_id;
                $changed = true;
            } elseif (!$should_have && $has_video) {
                $a['video_ids'] = array_values(array_filter($a['video_ids'], fn($id) => $id !== $video_id));
                $changed = true;
            }
        }
        unset($a);
        if ($changed) {
            saveArtists($artists);
            savePendingChanges(['artists' => $artists]);
        }

        // Handle landing page toggle
        $is_on_landing = false;
        foreach ($landing as $lp) {
            if (($lp['video_id'] ?? '') === $video_id) { $is_on_landing = true; break; }
        }
        if (isset($_POST['feature_landing']) && !$is_on_landing) {
            $lp_data = addVideoToLanding(
                $video_id,
                trim($_POST['landing_title'] ?? ''),
                trim($_POST['landing_subtitle'] ?? ''),
                implode(',', $_POST['tags'] ?? [])
            );
            saveLandingPageProjects($lp_data);
            savePendingChanges(['landing_page' => $lp_data]);
        } elseif (!isset($_POST['feature_landing']) && $is_on_landing) {
            $lp_data = removeVideoFromLanding($video_id);
            saveLandingPageProjects($lp_data);
            savePendingChanges(['landing_page' => $lp_data]);
        }

        clearCache();
        $videos = getVideos();
        $artists = getArtists();
        $landing = getLandingPageProjects();
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Video updated.</div>';
    }

    if ($action === 'delete_video') {
        $video_id = $_POST['video_id'] ?? '';
        // Remove from all artists
        $artists = getArtists();
        foreach ($artists as &$a) {
            $a['video_ids'] = array_values(array_filter($a['video_ids'] ?? [], fn($id) => $id !== $video_id));
        }
        unset($a);
        saveArtists($artists);
        savePendingChanges(['artists' => $artists]);
        // Remove from landing
        $lp_data = removeVideoFromLanding($video_id);
        saveLandingPageProjects($lp_data);
        savePendingChanges(['landing_page' => $lp_data]);
        // Remove from pool
        $videos = array_values(array_filter($videos, fn($v) => $v['id'] !== $video_id));
        saveVideos($videos);
        clearCache();
        $videos = getVideos();
        $artists = getArtists();
        $landing = getLandingPageProjects();
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Video deleted and all references removed.</div>';
    }

    if ($action === 'publish_changes') {
        $applied = applyPendingChanges();
        $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> All changes published.</div>';
        $videos = getVideos();
        $artists = getArtists();
        $landing = getLandingPageProjects();
    }
}

// Rebuild grouped artists after any changes
$artists_by_dept = ['EDIT' => [], 'COLOR' => [], 'SOUND' => [], 'VFX' => []];
foreach ($artists as $a) {
    $dept = $a['category'] ?? '';
    if (isset($artists_by_dept[$dept])) {
        $artists_by_dept[$dept][] = $a;
    }
}

// Build references
$refs_map = [];
foreach ($videos as $video) {
    $refs_map[$video['id']] = getVideoReferences($video['id']);
}

$total_videos = count($videos);
$tag_counts = ['EDIT' => 0, 'COLOR' => 0, 'SOUND' => 0, 'VFX' => 0];
foreach ($videos as $v) {
    foreach ($v['tags'] ?? [] as $t) {
        if (isset($tag_counts[$t])) $tag_counts[$t]++;
    }
}

$unlinked = 0;
foreach ($videos as $v) {
    $r = $refs_map[$v['id']] ?? ['artists' => [], 'landing' => []];
    if (empty($r['artists']) && empty($r['landing'])) $unlinked++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Pool - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .pool-stats { display:flex; gap:20px; margin-bottom:25px; flex-wrap:wrap; }
        .stat-card { background:var(--bg-secondary); border:1px solid var(--border-color); padding:18px 22px; border-radius:0; flex:1; min-width:100px; }
        .stat-label { font-size:11px; color:var(--text-secondary); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; }
        .stat-value { font-size:28px; font-weight:600; color:var(--text-primary); line-height:1; }
        .stat-warn { color:var(--warning); }
        .pool-toolbar { display:flex; gap:15px; align-items:center; margin-bottom:25px; flex-wrap:wrap; }
        .pool-toolbar .search-box { flex:1; min-width:220px; position:relative; }
        .pool-toolbar .search-box input { width:100%; background:var(--bg-secondary); border:1px solid var(--border-color); color:var(--text-primary); padding:12px 40px 12px 15px; border-radius:0; font-size:14px; }
        .pool-toolbar .search-box input:focus { outline:none; border-color:var(--accent); }
        .pool-toolbar .search-box i { position:absolute; right:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none; }
        .pool-toolbar .filter-select { background:var(--bg-secondary); border:1px solid var(--border-color); color:var(--text-primary); padding:12px 35px 12px 15px; border-radius:0; font-size:14px; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 9L1 4h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; background-size:12px; cursor:pointer; min-width:140px; }
        .pool-toolbar .filter-select:focus { outline:none; border-color:var(--accent); }
        .video-pool-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; }
        .pool-card { background:var(--bg-secondary); border:1px solid var(--border-color); border-radius:0; overflow:hidden; transition:all 0.2s ease; cursor:pointer; }
        .pool-card:hover { border-color:var(--accent); transform:translateY(-3px); box-shadow:0 6px 20px rgba(0,0,0,0.4); }
        .pool-card-thumb { position:relative; width:100%; padding-bottom:56.25%; background:#000; overflow:hidden; }
        .pool-card-thumb video, .pool-card-thumb img { position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; }
        .pool-card-thumb .no-thumb { position:absolute; top:0; left:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#111,#1a1a1a); }
        .pool-card-thumb .no-thumb i { font-size:36px; color:var(--text-muted); opacity:0.3; }
        .pool-card-body { padding:15px; }
        .pool-card-title { font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .pool-card-subtitle { font-size:12px; color:var(--text-secondary); margin-bottom:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .pool-card-links { display:flex; flex-wrap:wrap; gap:4px; }
        .pool-link { font-size:10px; padding:3px 7px; display:inline-flex; align-items:center; gap:4px; }
        .pool-link i { font-size:8px; }
        .pool-link-artist { background:rgba(96,165,250,.1); color:var(--info); border:1px solid rgba(96,165,250,.25); }
        .pool-link-landing { background:rgba(74,222,128,.1); color:var(--success); border:1px solid rgba(74,222,128,.25); }
        .pool-link-roster { background:rgba(251,191,36,.1); color:var(--warning); border:1px solid rgba(251,191,36,.25); }
        .pool-link-none { color:var(--text-muted); opacity:.4; border:1px solid var(--border-color); }

        .vp-modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.92); z-index:10000; overflow-y:auto; }
        .vp-modal-overlay.active { display:block; }
        .vp-modal { max-width:900px; width:94%; margin:30px auto; background:var(--bg-primary); border:1px solid var(--border-color); border-radius:0; position:relative; padding:30px; }
        .vp-modal-close { position:absolute; top:12px; right:15px; background:none; border:none; color:var(--text-secondary); font-size:22px; cursor:pointer; padding:5px 8px; transition:color 0.2s; }
        .vp-modal-close:hover { color:var(--accent); }
        .vp-modal h2 { font-size:20px; font-weight:600; margin-bottom:25px; color:var(--text-primary); }
        .vp-modal h2 i { margin-right:10px; }

        .upload-zone { border:2px dashed var(--border-color); background:var(--bg-tertiary); padding:30px; text-align:center; cursor:pointer; transition:all 0.2s ease; margin-bottom:10px; position:relative; }
        .upload-zone:hover, .upload-zone.dragover { border-color:var(--accent); background:var(--bg-hover); }
        .upload-zone i { font-size:28px; color:var(--text-muted); margin-bottom:8px; display:block; }
        .upload-zone p { margin:0; font-size:13px; color:var(--text-secondary); }
        .upload-zone.has-file { border-color:var(--success); border-style:solid; padding:0; overflow:hidden; }
        .upload-zone.has-file:hover { border-color:var(--accent); }
        .upload-zone.has-file video, .upload-zone.has-file img { display:block; width:100%; max-height:220px; object-fit:contain; background:#000; pointer-events:none; }
        .upload-zone.has-error { border-color:var(--danger); border-style:solid; }
        .upload-zone.has-error i { color:var(--danger); }
        .upload-zone.has-error p { color:var(--danger); font-weight:500; }
        .upload-zone-info { display:flex; align-items:center; justify-content:center; gap:8px; padding:10px 15px; background:rgba(74,222,128,0.08); border-top:1px solid rgba(74,222,128,0.15); }
        .upload-zone-info i { font-size:14px; color:var(--success); margin-bottom:0; display:inline; }
        .upload-zone-info span { font-size:12px; color:var(--success); font-weight:500; }
        .upload-zone-info small { font-size:11px; color:var(--text-muted); margin-left:auto; }
        .upload-progress { display:none; margin-top:10px; }
        .upload-progress .progress { height:6px; background:var(--bg-tertiary); border-radius:0; overflow:hidden; }
        .upload-progress .progress-bar { background:var(--accent); transition:width 0.3s ease; }

        .tag-checkboxes { display:flex; gap:15px; flex-wrap:wrap; }
        .tag-check-item { display:flex; align-items:center; gap:8px; cursor:pointer; }
        .tag-check-item input[type="checkbox"] { appearance:none; -webkit-appearance:none; width:18px; height:18px; border:2px solid var(--border-color); background:var(--bg-tertiary); border-radius:0; cursor:pointer; position:relative; flex-shrink:0; }
        .tag-check-item input[type="checkbox"]:checked { background:var(--success); border-color:var(--success); }
        .tag-check-item input[type="checkbox"]:checked::after { content:'\f00c'; font-family:'Font Awesome 6 Free'; font-weight:900; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); color:var(--bg-primary); font-size:10px; }
        .tag-check-item label { font-size:13px; color:var(--text-secondary); cursor:pointer; }

        .ref-warn { background:rgba(251,191,36,0.1); border:1px solid var(--warning); padding:12px 15px; margin-bottom:15px; font-size:13px; color:var(--warning); }
        .ref-warn i { margin-right:6px; }

        .section-divider { border-top:1px solid var(--border-color); margin:25px 0; padding-top:20px; }
        .section-divider h3 { font-size:16px; font-weight:600; color:var(--accent); margin-bottom:15px; }
        .section-divider h3 i { margin-right:8px; }

        .assign-dept { margin-bottom:15px; }
        .assign-dept-label { font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-secondary); margin-bottom:8px; padding-bottom:5px; border-bottom:1px solid var(--border-color); }
        .assign-artist-list { display:flex; flex-wrap:wrap; gap:10px; }
        .assign-artist-item { display:flex; align-items:center; gap:8px; padding:6px 12px; background:var(--bg-tertiary); border:1px solid var(--border-color); cursor:pointer; transition:all 0.15s; }
        .assign-artist-item:hover { border-color:var(--accent); }
        .assign-artist-item.checked { border-color:var(--success); background:rgba(74,222,128,0.1); }
        .assign-artist-item input[type="checkbox"] { appearance:none; -webkit-appearance:none; width:16px; height:16px; border:2px solid var(--border-color); background:var(--bg-tertiary); border-radius:0; cursor:pointer; position:relative; flex-shrink:0; }
        .assign-artist-item input[type="checkbox"]:checked { background:var(--success); border-color:var(--success); }
        .assign-artist-item input[type="checkbox"]:checked::after { content:'\f00c'; font-family:'Font Awesome 6 Free'; font-weight:900; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); color:var(--bg-primary); font-size:9px; }
        .assign-artist-item span { font-size:13px; color:var(--text-primary); }

        .landing-toggle { display:flex; align-items:center; gap:12px; padding:12px 16px; background:var(--bg-tertiary); border:1px solid var(--border-color); margin-bottom:15px; cursor:pointer; transition:all 0.15s; }
        .landing-toggle:hover { border-color:var(--accent); }
        .landing-toggle.checked { border-color:var(--success); background:rgba(74,222,128,0.1); }
        .landing-toggle input[type="checkbox"] { appearance:none; -webkit-appearance:none; width:18px; height:18px; border:2px solid var(--border-color); background:var(--bg-tertiary); border-radius:0; cursor:pointer; position:relative; flex-shrink:0; }
        .landing-toggle input[type="checkbox"]:checked { background:var(--success); border-color:var(--success); }
        .landing-toggle input[type="checkbox"]:checked::after { content:'\f00c'; font-family:'Font Awesome 6 Free'; font-weight:900; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); color:var(--bg-primary); font-size:10px; }
        .landing-fields { display:none; margin-top:10px; padding:15px; background:var(--bg-tertiary); border:1px solid var(--border-color); }
        .landing-fields.visible { display:block; }

        .empty-pool { text-align:center; padding:60px 20px; color:var(--text-muted); }
        .empty-pool i { font-size:48px; margin-bottom:15px; opacity:0.3; }

        /* Credits Editor */
        .credits-editor { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
        @media(max-width:768px) { .credits-editor { grid-template-columns:1fr; } }
        .credits-col { background:var(--bg-tertiary); border:1px solid var(--border-color); padding:16px; }
        .credits-col-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; padding-bottom:10px; border-bottom:1px solid var(--border-color); }
        .credits-col-header h4 { font-size:13px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-primary); margin:0; }
        .credits-col-header button { background:none; border:1px solid var(--border-color); color:var(--text-secondary); font-size:11px; padding:4px 10px; cursor:pointer; transition:all .15s; display:flex; align-items:center; gap:4px; }
        .credits-col-header button:hover { border-color:var(--accent); color:var(--accent); }
        .credits-lines { display:flex; flex-direction:column; gap:6px; }
        .credit-line { display:flex; gap:6px; align-items:center; cursor:grab; }
        .credit-line.dragging { opacity:.4; }
        .credit-line.drag-over { border-top:2px solid var(--accent, #fff); margin-top:-2px; }
        .credit-line .credit-drag { flex-shrink:0; color:var(--text-muted); font-size:10px; cursor:grab; padding:4px 2px; opacity:.4; transition:opacity .15s; }
        .credit-line:hover .credit-drag { opacity:1; }
        .credit-line input { background:var(--bg-secondary); border:1px solid var(--border-color); color:var(--text-primary); font-size:12px; padding:7px 10px; flex:1; min-width:0; }
        .credit-line input:focus { outline:none; border-color:var(--accent); }
        .credit-line input.credit-role { flex:0 0 38%; }
        .credit-line input.credit-name { flex:1; }
        .credit-line .credit-remove { background:none; border:none; color:var(--text-muted); cursor:pointer; padding:4px 6px; font-size:11px; flex-shrink:0; transition:color .15s; }
        .credit-line .credit-remove:hover { color:#e55; }
        .credits-empty { text-align:center; padding:16px 8px; color:var(--text-muted); font-size:12px; }
        .credits-role-tags { display:flex; flex-wrap:wrap; gap:4px; margin-bottom:10px; }
        .credits-role-tag { background:rgba(255,255,255,.06); border:1px solid var(--border-color); color:var(--text-secondary); font-size:10px; padding:3px 8px; cursor:pointer; transition:all .15s; white-space:nowrap; }
        .credits-role-tag:hover { border-color:var(--accent); color:var(--accent); }
        .credits-auto-btn { background:rgba(96,165,250,.1); border:1px solid rgba(96,165,250,.3); color:var(--info, #60a5fa); font-size:11px; padding:4px 10px; cursor:pointer; transition:all .15s; display:flex; align-items:center; gap:5px; }
        .credits-auto-btn:hover { background:rgba(96,165,250,.2); border-color:rgba(96,165,250,.5); }
        .credits-row-lower { display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap; margin-bottom:15px; }
        .credits-row-lower .form-check { margin:0; }

        @media (max-width: 768px) { .video-pool-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-database"></i> Video Pool</h1>
            <button class="btn-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Add New Video</button>
        </div>

        <?php if ($message) echo $message; ?>

        <div class="pool-stats">
            <div class="stat-card">
                <div class="stat-label">Total Videos</div>
                <div class="stat-value"><?php echo $total_videos; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Unlinked</div>
                <div class="stat-value <?php echo $unlinked > 0 ? 'stat-warn' : ''; ?>"><?php echo $unlinked; ?></div>
            </div>
            <?php foreach ($tag_counts as $tag => $cnt): ?>
            <div class="stat-card">
                <div class="stat-label"><?php echo $tag; ?></div>
                <div class="stat-value"><?php echo $cnt; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="pool-toolbar">
            <div class="search-box">
                <input type="text" id="poolSearch" placeholder="Search by title, subtitle, or tags..." oninput="filterPool()">
                <i class="fas fa-search"></i>
            </div>
            <select class="filter-select" id="poolTagFilter" onchange="filterPool()">
                <option value="">All Tags</option>
                <option value="EDIT">Edit</option>
                <option value="COLOR">Color</option>
                <option value="SOUND">Sound</option>
                <option value="VFX">VFX</option>
            </select>
            <select class="filter-select" id="poolLinkFilter" onchange="filterPool()">
                <option value="">All Status</option>
                <option value="linked">Linked</option>
                <option value="unlinked">Unlinked</option>
            </select>
        </div>

        <?php if ($total_videos === 0): ?>
            <div class="empty-pool">
                <i class="fas fa-database"></i>
                <p>No videos in the pool yet</p>
                <small>Click "Add New Video" to get started</small>
            </div>
        <?php else: ?>
            <div class="video-pool-grid" id="poolGrid">
                <?php foreach ($videos as $video):
                    $vid_id = $video['id'];
                    $thumb_src = !empty($video['videoShort']) ? '../roster/' . $video['videoShort'] : '';
                    $poster_src = !empty($video['poster']) ? '../roster/' . $video['poster'] : '';
                    $tags = $video['tags'] ?? [];
                    $refs = $refs_map[$vid_id] ?? ['artists' => [], 'landing' => [], 'roster_depts' => []];
                    $ref_count = count($refs['artists']) + count($refs['landing']);
                    $search_blob = strtolower(($video['title'] ?? '') . ' ' . ($video['subtitle'] ?? '') . ' ' . implode(' ', $tags));
                ?>
                    <div class="pool-card"
                         data-search="<?php echo htmlspecialchars($search_blob); ?>"
                         data-tags="<?php echo htmlspecialchars(implode(',', $tags)); ?>"
                         data-linked="<?php echo $ref_count > 0 ? 'linked' : 'unlinked'; ?>"
                         onclick="openEditModal('<?php echo htmlspecialchars($vid_id); ?>')">
                        <div class="pool-card-thumb" data-video="<?php echo htmlspecialchars($thumb_src); ?>">
                            <?php if ($poster_src): ?>
                                <img src="<?php echo htmlspecialchars($poster_src); ?>" alt="" loading="lazy">
                            <?php elseif ($thumb_src): ?>
                                <video src="<?php echo htmlspecialchars($thumb_src); ?>#t=0.5" preload="metadata" muted playsinline></video>
                            <?php else: ?>
                                <div class="no-thumb"><i class="fas fa-film"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="pool-card-body">
                            <div class="pool-card-title"><?php echo htmlspecialchars($video['title'] ?? 'Untitled'); ?></div>
                            <div class="pool-card-subtitle"><?php echo htmlspecialchars($video['subtitle'] ?? ''); ?>&nbsp;</div>
                            <div class="pool-card-links">
                                <?php foreach ($refs['artists'] as $a): ?>
                                    <span class="pool-link pool-link-artist"><i class="fas fa-user"></i> <?php echo htmlspecialchars($a['name']); ?></span>
                                <?php endforeach; ?>
                                <?php if (!empty($refs['landing'])): ?>
                                    <span class="pool-link pool-link-landing"><i class="fas fa-home"></i> Landing Page</span>
                                <?php endif; ?>
                                <?php foreach ($refs['roster_depts'] as $dept): ?>
                                    <span class="pool-link pool-link-roster"><i class="fas fa-th"></i> <?php echo $dept; ?> Roster</span>
                                <?php endforeach; ?>
                                <?php if ($ref_count === 0): ?>
                                    <span class="pool-link pool-link-none"><i class="fas fa-unlink"></i> Not linked</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Add Video Modal -->
    <div class="vp-modal-overlay" id="addModal" onclick="if(event.target===this)closeAddModal()">
        <div class="vp-modal" onclick="event.stopPropagation()">
            <button class="vp-modal-close" onclick="closeAddModal()"><i class="fas fa-times"></i></button>
            <h2><i class="fas fa-plus-circle"></i> Add New Video</h2>
            <form method="POST" id="addForm">
                <input type="hidden" name="action" value="add_video">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" required placeholder="e.g. Duckwrth">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" class="form-control" name="subtitle" placeholder="e.g. Vertigo">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Video (Preview)</label>
                    <div class="upload-zone" id="addVideoZone" onclick="document.getElementById('addVideoFile').click()"
                         ondragover="event.preventDefault();this.classList.add('dragover')"
                         ondragleave="this.classList.remove('dragover')"
                         ondrop="event.preventDefault();this.classList.remove('dragover');handleUpload(event.dataTransfer.files[0],'video','addVideoShort','addVideoZone','addVideoProgress')">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click or drag to upload video (MP4, WebM, MOV)</p>
                    </div>
                    <div class="upload-progress" id="addVideoProgress">
                        <div class="progress"><div class="progress-bar" style="width:0%"></div></div>
                    </div>
                    <input type="file" id="addVideoFile" accept="video/*" style="display:none"
                           onchange="handleUpload(this.files[0],'video','addVideoShort','addVideoZone','addVideoProgress')">
                    <input type="text" class="form-control mt-2" name="videoShort" id="addVideoShort" placeholder="Or paste path: videos/short/filename.mp4">
                </div>

                <div class="mb-3">
                    <label class="form-label">Poster Image</label>
                    <div class="upload-zone" id="addPosterZone" onclick="document.getElementById('addPosterFile').click()"
                         ondragover="event.preventDefault();this.classList.add('dragover')"
                         ondragleave="this.classList.remove('dragover')"
                         ondrop="event.preventDefault();this.classList.remove('dragover');handleUpload(event.dataTransfer.files[0],'poster','addPoster','addPosterZone','addPosterProgress')">
                        <i class="fas fa-image"></i>
                        <p>Click or drag to upload poster (JPG, PNG, WebP)</p>
                    </div>
                    <div class="upload-progress" id="addPosterProgress">
                        <div class="progress"><div class="progress-bar" style="width:0%"></div></div>
                    </div>
                    <input type="file" id="addPosterFile" accept="image/*" style="display:none"
                           onchange="handleUpload(this.files[0],'poster','addPoster','addPosterZone','addPosterProgress')">
                    <input type="text" class="form-control mt-2" name="poster" id="addPoster" placeholder="Or paste path: videos/images/poster.png">
                </div>

                <div class="mb-3">
                    <label class="form-label">Simian Embed Code (Full Video)</label>
                    <input type="text" class="form-control" name="videoLong" placeholder="Paste Simian embed code or URL...">
                </div>

                <div class="section-divider" style="margin-top:20px;">
                    <h3><i class="fas fa-align-left"></i> Credits</h3>
                    <input type="hidden" name="credits" id="addCreditsHidden">
                    <div class="credits-editor" id="addCreditsEditor">
                        <div class="credits-col">
                            <div class="credits-col-header">
                                <h4>Apollo</h4>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="credits-auto-btn" onclick="autoPopulateCredits('addCreditsEditor','addForm')"><i class="fas fa-magic"></i> Auto-fill from Artists</button>
                                    <button type="button" onclick="addCreditLine('addCreditsEditor','apollo')"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <div class="credits-role-tags" data-editor="addCreditsEditor" data-section="apollo"></div>
                            <div class="credits-lines" data-section="apollo"></div>
                        </div>
                        <div class="credits-col">
                            <div class="credits-col-header">
                                <h4>Production</h4>
                                <button type="button" onclick="addCreditLine('addCreditsEditor','production')"><i class="fas fa-plus"></i> Add</button>
                            </div>
                            <div class="credits-role-tags" data-editor="addCreditsEditor" data-section="production"></div>
                            <div class="credits-lines" data-section="production"></div>
                        </div>
                    </div>
                    <div class="credits-row-lower">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="hasCredit" id="addHasCredit">
                            <label class="form-check-label" for="addHasCredit">Show Credits on Video Page</label>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <label class="form-label" style="margin:0;font-size:13px;">Tags:</label>
                            <div class="tag-checkboxes">
                                <?php foreach (CATEGORY_LABELS as $key => $label): ?>
                                    <label class="tag-check-item">
                                        <input type="checkbox" name="tags[]" value="<?php echo $key; ?>">
                                        <label><?php echo $key; ?></label>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Assignments -->
                <div class="section-divider">
                    <h3><i class="fas fa-link"></i> Assign to Artists</h3>
                    <p style="font-size:12px; color:var(--text-muted); margin-bottom:15px;">Select one or more artists. The same video can be linked to multiple artists across departments.</p>
                    <?php foreach ($artists_by_dept as $dept => $dept_artists): ?>
                        <?php if (!empty($dept_artists)): ?>
                        <div class="assign-dept">
                            <div class="assign-dept-label"><?php echo $dept; ?> (<?php echo CATEGORY_LABELS[$dept] ?? $dept; ?>s)</div>
                            <div class="assign-artist-list">
                                <?php foreach ($dept_artists as $a): ?>
                                <label class="assign-artist-item" onclick="this.classList.toggle('checked')" data-artist-name="<?php echo htmlspecialchars($a['name']); ?>" data-artist-dept="<?php echo htmlspecialchars($dept); ?>">
                                    <input type="checkbox" name="artist_ids[]" value="<?php echo htmlspecialchars($a['id']); ?>" onchange="onArtistToggle(this,'addCreditsEditor')">
                                    <span><?php echo htmlspecialchars($a['name']); ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="section-divider">
                    <h3><i class="fas fa-star"></i> Feature on Landing Page</h3>
                    <label class="landing-toggle" onclick="this.classList.toggle('checked'); document.getElementById('addLandingFields').classList.toggle('visible')">
                        <input type="checkbox" name="feature_landing" id="addFeatureLanding">
                        <span style="font-size:14px; color:var(--text-primary);">Add this video to the homepage</span>
                    </label>
                    <div class="landing-fields" id="addLandingFields">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label" style="font-size:12px;">Title Override (optional)</label>
                                <input type="text" class="form-control" name="landing_title" placeholder="Leave blank to use video title">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" style="font-size:12px;">Subtitle Override (optional)</label>
                                <input type="text" class="form-control" name="landing_subtitle" placeholder="Leave blank to use video subtitle">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions" style="margin-top:20px;">
                    <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Add Video & Save Assignments</button>
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div class="vp-modal-overlay" id="editModal" onclick="if(event.target===this)closeEditModal()">
        <div class="vp-modal" onclick="event.stopPropagation()">
            <button class="vp-modal-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
            <div id="editModalContent"></div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="vp-modal-overlay" id="deleteModal" onclick="if(event.target===this)closeDeleteModal()">
        <div class="vp-modal" style="max-width:500px" onclick="event.stopPropagation()">
            <button class="vp-modal-close" onclick="closeDeleteModal()"><i class="fas fa-times"></i></button>
            <div id="deleteModalContent"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const videosData = <?php echo json_encode($videos, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES); ?>;
        const refsData = <?php echo json_encode($refs_map, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES); ?>;
        const categoryLabels = <?php echo json_encode(CATEGORY_LABELS); ?>;
        const artistsByDept = <?php echo json_encode($artists_by_dept, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES); ?>;
        const landingProjects = <?php echo json_encode($landing, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES); ?>;

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str || '';
            return div.innerHTML;
        }

        function escapeAttr(str) {
            if (!str) return '';
            return str.replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/'/g,'&#39;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }

        function filterPool() {
            const q = document.getElementById('poolSearch').value.toLowerCase();
            const tag = document.getElementById('poolTagFilter').value;
            const link = document.getElementById('poolLinkFilter').value;
            document.querySelectorAll('.pool-card').forEach(card => {
                const matchQ = !q || card.dataset.search.includes(q);
                const matchTag = !tag || card.dataset.tags.split(',').includes(tag);
                const matchLink = !link || card.dataset.linked === link;
                card.style.display = (matchQ && matchTag && matchLink) ? '' : 'none';
            });
        }

        document.querySelectorAll('.pool-card').forEach(card => {
            const thumb = card.querySelector('.pool-card-thumb');
            const videoSrc = thumb?.dataset.video;
            if (!videoSrc) return;
            let videoEl = null;
            card.addEventListener('mouseenter', () => {
                if (!videoEl) {
                    videoEl = document.createElement('video');
                    videoEl.src = videoSrc;
                    videoEl.muted = true;
                    videoEl.loop = true;
                    videoEl.playsInline = true;
                    thumb.appendChild(videoEl);
                }
                videoEl.style.display = 'block';
                videoEl.play().catch(() => {});
            });
            card.addEventListener('mouseleave', () => {
                if (videoEl) { videoEl.pause(); videoEl.style.display = 'none'; }
            });
        });

        function showZoneError(zone, msg) {
            if (!zone) return;
            zone.classList.remove('has-file');
            zone.classList.add('has-error');
            zone.innerHTML = '<i class="fas fa-exclamation-triangle"></i><p>' + escapeHtml(msg) + '</p><small style="color:var(--text-muted);font-size:11px;">Click to try again</small>';
        }

        function handleUpload(file, type, inputId, zoneId, progressId) {
            if (!file) return;
            const zone = zoneId ? document.getElementById(zoneId) : null;
            const progress = document.getElementById(progressId);
            const bar = progress.querySelector('.progress-bar');
            const input = document.getElementById(inputId);
            if (zone) {
                zone.classList.remove('has-file', 'has-error');
                const icon = type === 'video' ? 'fa-cloud-upload-alt' : 'fa-image';
                zone.innerHTML = '<i class="fas ' + icon + '"></i><p>Uploading ' + escapeHtml(file.name) + '…</p>';
            }
            progress.style.display = 'block';
            bar.style.width = '0%';
            const fd = new FormData();
            fd.append('file', file);
            fd.append('type', type);
            const xhr = new XMLHttpRequest();
            xhr.timeout = 120000;
            xhr.upload.addEventListener('progress', e => {
                if (e.lengthComputable) bar.style.width = Math.round(e.loaded / e.total * 100) + '%';
            });
            xhr.addEventListener('load', () => {
                progress.style.display = 'none';
                if (xhr.status !== 200) {
                    showZoneError(zone, 'Server error (HTTP ' + xhr.status + '). The file may be too large.');
                    return;
                }
                let res;
                try { res = JSON.parse(xhr.responseText); } catch (e) {
                    showZoneError(zone, 'Server returned an invalid response. Check PHP error logs.');
                    console.error('Upload response was not JSON:', xhr.responseText.substring(0, 500));
                    return;
                }
                if (res.success) {
                    input.value = res.path;
                    if (zone) {
                        const filePath = '../roster/' + res.path;
                        let previewEl = '';
                        if (type === 'video') {
                            previewEl = '<video src="' + escapeHtml(filePath) + '" muted loop playsinline autoplay></video>';
                        } else {
                            previewEl = '<img src="' + escapeHtml(filePath) + '" alt="' + escapeHtml(res.filename) + '">';
                        }
                        zone.classList.add('has-file');
                        zone.innerHTML = previewEl +
                            '<div class="upload-zone-info">' +
                                '<i class="fas fa-check-circle"></i>' +
                                '<span>' + escapeHtml(res.filename) + ' (' + res.size_formatted + ')</span>' +
                                '<small>Click to replace</small>' +
                            '</div>';
                    }
                } else {
                    showZoneError(zone, res.error || 'Upload failed');
                }
            });
            xhr.addEventListener('error', () => {
                progress.style.display = 'none';
                showZoneError(zone, 'Network error — connection to server failed.');
            });
            xhr.addEventListener('timeout', () => {
                progress.style.display = 'none';
                showZoneError(zone, 'Upload timed out. Try a smaller file or check your connection.');
            });
            xhr.addEventListener('abort', () => {
                progress.style.display = 'none';
                showZoneError(zone, 'Upload was cancelled.');
            });
            xhr.open('POST', 'upload-video.php');
            xhr.send(fd);
        }

        var _savedScrollY = 0;
        function lockScroll() {
            _savedScrollY = window.scrollY;
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + _savedScrollY + 'px';
            document.body.style.width = '100%';
        }
        function unlockScroll() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';
            window.scrollTo(0, _savedScrollY);
        }

        function openAddModal() {
            document.getElementById('addForm').reset();
            const videoZone = document.getElementById('addVideoZone');
            const posterZone = document.getElementById('addPosterZone');
            videoZone.classList.remove('has-file', 'has-error');
            videoZone.innerHTML = '<i class="fas fa-cloud-upload-alt"></i><p>Click or drag to upload video (MP4, WebM, MOV)</p>';
            posterZone.classList.remove('has-file', 'has-error');
            posterZone.innerHTML = '<i class="fas fa-image"></i><p>Click or drag to upload poster (JPG, PNG, WebP)</p>';
            document.querySelectorAll('#addForm .assign-artist-item').forEach(el => el.classList.remove('checked'));
            document.getElementById('addLandingFields').classList.remove('visible');
            document.querySelectorAll('#addForm .landing-toggle').forEach(el => el.classList.remove('checked'));
            populateCreditsEditor('addCreditsEditor', '');
            document.getElementById('addModal').classList.add('active');
            lockScroll();
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.remove('active');
            unlockScroll();
        }

        function openEditModal(videoId) {
            const video = videosData.find(v => v.id === videoId);
            if (!video) return;
            const refs = refsData[videoId] || { artists: [], landing: [] };
            const tags = video.tags || [];
            const linkedArtistIds = (refs.artists || []).map(a => a.id);
            const isOnLanding = (refs.landing || []).length > 0;
            const landingProj = isOnLanding ? refs.landing[0] : null;

            const videoShort = video.videoShort ? '../roster/' + video.videoShort : '';
            const poster = video.poster ? '../roster/' + video.poster : '';

            let previewHtml = '';
            if (videoShort) {
                previewHtml = `<div style="position:relative;padding-bottom:56.25%;background:#000;margin-bottom:20px;overflow:hidden;">
                    <video src="${escapeHtml(videoShort)}" muted loop playsinline autoplay
                        ${poster ? 'poster="' + escapeHtml(poster) + '"' : ''}
                        style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;"></video></div>`;
            }

            const tagChecks = ['EDIT','COLOR','SOUND','VFX'].map(t =>
                `<label class="tag-check-item"><input type="checkbox" name="tags[]" value="${t}" ${tags.includes(t)?'checked':''}><label>${t}</label></label>`
            ).join('');

            // Build artist assignment HTML
            let assignHtml = '';
            for (const [dept, deptArtists] of Object.entries(artistsByDept)) {
                if (deptArtists.length === 0) continue;
                assignHtml += `<div class="assign-dept"><div class="assign-dept-label">${dept} (${categoryLabels[dept]||dept}s)</div><div class="assign-artist-list">`;
                deptArtists.forEach(a => {
                    const isChecked = linkedArtistIds.includes(a.id);
                    assignHtml += `<label class="assign-artist-item ${isChecked?'checked':''}" onclick="this.classList.toggle('checked')" data-artist-name="${escapeAttr(a.name)}" data-artist-dept="${escapeAttr(dept)}">
                        <input type="checkbox" name="artist_ids[]" value="${escapeAttr(a.id)}" ${isChecked?'checked':''} onchange="onArtistToggle(this,'editCreditsEditor')">
                        <span>${escapeHtml(a.name)}</span></label>`;
                });
                assignHtml += `</div></div>`;
            }

            const landingTitle = landingProj ? (landingProj.title_override || '') : '';
            const landingSub = landingProj ? (landingProj.subtitle_override || '') : '';

            document.getElementById('editModalContent').innerHTML = `
                <h2><i class="fas fa-edit"></i> Edit Video</h2>
                ${previewHtml}
                <form method="POST" id="editForm">
                    <input type="hidden" name="action" value="edit_video">
                    <input type="hidden" name="video_id" value="${escapeAttr(video.id)}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" name="title" value="${escapeAttr(video.title||'')}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" class="form-control" name="subtitle" value="${escapeAttr(video.subtitle||'')}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Video Path</label>
                        <div style="display:flex;gap:10px;align-items:center;">
                            <input type="text" class="form-control" name="videoShort" id="editVideoShort" value="${escapeAttr(video.videoShort||'')}" style="flex:1">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('editVideoFile').click()" style="white-space:nowrap;border-radius:0">
                                <i class="fas fa-upload"></i> Upload</button>
                        </div>
                        <input type="file" id="editVideoFile" accept="video/*" style="display:none"
                               onchange="handleUpload(this.files[0],'video','editVideoShort',null,'editVideoProgress')">
                        <div class="upload-progress" id="editVideoProgress">
                            <div class="progress"><div class="progress-bar" style="width:0%"></div></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poster Image Path</label>
                        <div style="display:flex;gap:10px;align-items:center;">
                            <input type="text" class="form-control" name="poster" id="editPoster" value="${escapeAttr(video.poster||'')}" style="flex:1">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('editPosterFile').click()" style="white-space:nowrap;border-radius:0">
                                <i class="fas fa-upload"></i> Upload</button>
                        </div>
                        <input type="file" id="editPosterFile" accept="image/*" style="display:none"
                               onchange="handleUpload(this.files[0],'poster','editPoster',null,'editPosterProgress')">
                        <div class="upload-progress" id="editPosterProgress">
                            <div class="progress"><div class="progress-bar" style="width:0%"></div></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Simian Embed Code (Full Video)</label>
                        <input type="text" class="form-control" name="videoLong" id="editVideoLong">
                    </div>

                    <div class="section-divider" style="margin-top:20px;">
                        <h3><i class="fas fa-align-left"></i> Credits</h3>
                        <input type="hidden" name="credits" id="editCreditsHidden">
                        <div class="credits-editor" id="editCreditsEditor">
                            <div class="credits-col">
                                <div class="credits-col-header">
                                    <h4>Apollo</h4>
                                    <div style="display:flex;gap:6px;">
                                        <button type="button" class="credits-auto-btn" onclick="autoPopulateCredits('editCreditsEditor','editForm')"><i class="fas fa-magic"></i> Auto-fill from Artists</button>
                                        <button type="button" onclick="addCreditLine('editCreditsEditor','apollo')"><i class="fas fa-plus"></i> Add</button>
                                    </div>
                                </div>
                                <div class="credits-role-tags" data-editor="editCreditsEditor" data-section="apollo"></div>
                                <div class="credits-lines" data-section="apollo"></div>
                            </div>
                            <div class="credits-col">
                                <div class="credits-col-header">
                                    <h4>Production</h4>
                                    <button type="button" onclick="addCreditLine('editCreditsEditor','production')"><i class="fas fa-plus"></i> Add</button>
                                </div>
                                <div class="credits-role-tags" data-editor="editCreditsEditor" data-section="production"></div>
                                <div class="credits-lines" data-section="production"></div>
                            </div>
                        </div>
                        <div class="credits-row-lower">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="hasCredit" id="editHasCredit" ${video.hasCredit?'checked':''}>
                                <label class="form-check-label" for="editHasCredit">Show Credits on Video Page</label>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <label class="form-label" style="margin:0;font-size:13px;">Tags:</label>
                                <div class="tag-checkboxes">${tagChecks}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <h3><i class="fas fa-link"></i> Assign to Artists</h3>
                        <p style="font-size:12px;color:var(--text-muted);margin-bottom:15px;">Check/uncheck artists. Changes are saved when you click Save.</p>
                        ${assignHtml}
                    </div>

                    <div class="section-divider">
                        <h3><i class="fas fa-star"></i> Feature on Landing Page</h3>
                        <label class="landing-toggle ${isOnLanding?'checked':''}" onclick="this.classList.toggle('checked');document.getElementById('editLandingFields').classList.toggle('visible')">
                            <input type="checkbox" name="feature_landing" ${isOnLanding?'checked':''}>
                            <span style="font-size:14px;color:var(--text-primary);">Add this video to the homepage</span>
                        </label>
                        <div class="landing-fields ${isOnLanding?'visible':''}" id="editLandingFields">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" style="font-size:12px;">Title Override (optional)</label>
                                    <input type="text" class="form-control" name="landing_title" value="${escapeAttr(landingTitle)}" placeholder="Leave blank to use video title">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" style="font-size:12px;">Subtitle Override (optional)</label>
                                    <input type="text" class="form-control" name="landing_subtitle" value="${escapeAttr(landingSub)}" placeholder="Leave blank to use video subtitle">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top:20px;">
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save All Changes</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('${escapeAttr(video.id)}')" style="border-radius:0">
                            <i class="fas fa-trash"></i> Delete</button>
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    </div>
                </form>`;

            document.getElementById('editVideoLong').value = video.videoLong || '';
            populateCreditsEditor('editCreditsEditor', video.credits || '');

            document.getElementById('editModal').classList.add('active');
            lockScroll();
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            unlockScroll();
            document.querySelectorAll('#editModal video').forEach(v => { v.pause(); v.currentTime = 0; });
        }

        function confirmDelete(videoId) {
            const video = videosData.find(v => v.id === videoId);
            if (!video) return;
            const refs = refsData[videoId] || { artists: [], landing: [] };
            const refCount = (refs.artists||[]).length + (refs.landing||[]).length;
            let warnHtml = '';
            if (refCount > 0) {
                const names = [];
                (refs.artists||[]).forEach(a => names.push(escapeHtml(a.name)));
                (refs.landing||[]).forEach(() => names.push('Landing Page'));
                warnHtml = `<div class="ref-warn"><i class="fas fa-exclamation-triangle"></i> <strong>Warning:</strong> This video is referenced by ${refCount} item(s): ${names.join(', ')}. All references will be automatically removed.</div>`;
            }
            document.getElementById('deleteModalContent').innerHTML = `
                <h2><i class="fas fa-trash" style="color:var(--danger)"></i> Delete Video</h2>
                ${warnHtml}
                <p style="color:var(--text-secondary);font-size:14px;margin-bottom:20px;">
                    Are you sure you want to delete <strong>${escapeHtml(video.title)}</strong>? This cannot be undone.</p>
                <form method="POST">
                    <input type="hidden" name="action" value="delete_video">
                    <input type="hidden" name="video_id" value="${escapeHtml(video.id)}">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger" style="border-radius:0"><i class="fas fa-trash"></i> Delete Permanently</button>
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    </div>
                </form>`;
            document.getElementById('deleteModal').classList.add('active');
        }
        function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('active'); }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') { closeAddModal(); closeEditModal(); closeDeleteModal(); }
        });

        // ── Credits Editor ──

        var apolloRoleTags = ['Post Producer', 'Post Supervisor', 'Color Producer', 'Editor', 'Colorist', 'Sound Designer', 'VFX'];
        var productionRoleTags = ['Production Company', 'Director', 'Executive Producer', 'Producer', 'DP'];
        var deptToRole = { EDIT: 'Editor', COLOR: 'Colorist', SOUND: 'Sound Designer', VFX: 'VFX Artist' };

        function parseCreditsHtml(html) {
            var result = { apollo: [], production: [] };
            if (!html) return result;
            var text = html.replace(/<br\s*\/?>/gi, '\n').replace(/<\/?b>/gi, '').replace(/&nbsp;/gi, ' ');
            var sections = text.split(/<h3[^>]*>/i);
            for (var i = 0; i < sections.length; i++) {
                var part = sections[i];
                var target = null;
                if (/^apollo/i.test(part.trim())) target = 'apollo';
                else if (/^production/i.test(part.trim())) target = 'production';
                if (!target) continue;
                part = part.replace(/<\/h3>/i, '').replace(/^(apollo|production):?\s*/i, '');
                var lines = part.split('\n');
                for (var j = 0; j < lines.length; j++) {
                    var line = lines[j].replace(/<[^>]*>/g, '').trim();
                    if (!line) continue;
                    var colonIdx = line.indexOf(':');
                    if (colonIdx > 0 && colonIdx < 40) {
                        result[target].push({
                            role: line.substring(0, colonIdx).trim(),
                            name: line.substring(colonIdx + 1).trim()
                        });
                    } else {
                        result[target].push({ role: '', name: line });
                    }
                }
            }
            return result;
        }

        function buildCreditLineHtml(role, name) {
            return '<div class="credit-line" draggable="true">' +
                '<span class="credit-drag"><i class="fas fa-grip-vertical"></i></span>' +
                '<input type="text" class="credit-role" placeholder="Role (e.g. Editor)" value="' + escapeAttr(role) + '">' +
                '<input type="text" class="credit-name" placeholder="Name" value="' + escapeAttr(name) + '">' +
                '<button type="button" class="credit-remove" onclick="this.parentNode.remove()" title="Remove"><i class="fas fa-times"></i></button>' +
                '</div>';
        }

        function addCreditLine(editorId, section, role, name) {
            var editor = document.getElementById(editorId);
            var container = editor.querySelector('.credits-lines[data-section="' + section + '"]');
            container.insertAdjacentHTML('beforeend', buildCreditLineHtml(role || '', name || ''));
            initCreditDrag(container);
        }

        function renderRoleTags(editorId) {
            var tagContainers = document.querySelectorAll('.credits-role-tags[data-editor="' + editorId + '"]');
            tagContainers.forEach(function(container) {
                var section = container.dataset.section;
                var tags = section === 'production' ? productionRoleTags : apolloRoleTags;
                container.innerHTML = tags.map(function(role) {
                    return '<span class="credits-role-tag" onclick="addCreditLine(\'' + editorId + '\',\'' + section + '\',\'' + escapeAttr(role) + '\',\'\')">' + escapeHtml(role) + '</span>';
                }).join('');
            });
        }

        function populateCreditsEditor(editorId, html) {
            var data = parseCreditsHtml(html);
            var editor = document.getElementById(editorId);
            editor.querySelector('.credits-lines[data-section="apollo"]').innerHTML = '';
            editor.querySelector('.credits-lines[data-section="production"]').innerHTML = '';
            data.apollo.forEach(function(c) { addCreditLine(editorId, 'apollo', c.role, c.name); });
            data.production.forEach(function(c) { addCreditLine(editorId, 'production', c.role, c.name); });
            renderRoleTags(editorId);
        }

        function onArtistToggle(checkbox, editorId) {
            var label = checkbox.closest('.assign-artist-item');
            var name = label.dataset.artistName || '';
            var dept = label.dataset.artistDept || '';
            var role = deptToRole[dept] || dept;
            var editor = document.getElementById(editorId);
            var container = editor.querySelector('.credits-lines[data-section="apollo"]');

            if (checkbox.checked) {
                var exists = false;
                container.querySelectorAll('.credit-line').forEach(function(line) {
                    if (line.querySelector('.credit-name').value.trim().toLowerCase() === name.toLowerCase()) {
                        exists = true;
                    }
                });
                if (!exists) {
                    addCreditLine(editorId, 'apollo', role, name);
                }
            } else {
                container.querySelectorAll('.credit-line').forEach(function(line) {
                    if (line.querySelector('.credit-name').value.trim().toLowerCase() === name.toLowerCase()) {
                        line.remove();
                    }
                });
            }
        }

        function autoPopulateCredits(editorId, formId) {
            var form = document.getElementById(formId);
            var checkedArtists = form.querySelectorAll('.assign-artist-item input[type="checkbox"]:checked');
            if (checkedArtists.length === 0) {
                alert('No artists are assigned to this video. Please assign artists first, then click Auto-fill.');
                return;
            }
            var existing = [];
            var editor = document.getElementById(editorId);
            editor.querySelectorAll('.credits-lines[data-section="apollo"] .credit-line').forEach(function(line) {
                var n = line.querySelector('.credit-name').value.trim().toLowerCase();
                if (n) existing.push(n);
            });
            checkedArtists.forEach(function(cb) {
                var artistId = cb.value;
                var artistName = '';
                var artistDept = '';
                for (var dept in artistsByDept) {
                    for (var j = 0; j < artistsByDept[dept].length; j++) {
                        if (artistsByDept[dept][j].id === artistId) {
                            artistName = artistsByDept[dept][j].name;
                            artistDept = dept;
                            break;
                        }
                    }
                    if (artistName) break;
                }
                if (!artistName) return;
                if (existing.indexOf(artistName.toLowerCase()) !== -1) return;
                var role = deptToRole[artistDept] || artistDept;
                addCreditLine(editorId, 'apollo', role, artistName);
                existing.push(artistName.toLowerCase());
            });
        }

        function gatherCreditsHtml(editorId) {
            var editor = document.getElementById(editorId);
            var html = '';
            ['apollo', 'production'].forEach(function(section) {
                var lines = editor.querySelectorAll('.credits-lines[data-section="' + section + '"] .credit-line');
                var entries = [];
                lines.forEach(function(line) {
                    var role = line.querySelector('.credit-role').value.trim();
                    var name = line.querySelector('.credit-name').value.trim();
                    if (role || name) {
                        entries.push(role ? ('<b>' + escapeHtml(role) + ':</b> ' + escapeHtml(name)) : escapeHtml(name));
                    }
                });
                if (entries.length > 0) {
                    var heading = section === 'apollo' ? 'Apollo' : 'Production';
                    html += '<h3>' + heading + '</h3>' + entries.join('<br>');
                    html += '<br><br>';
                }
            });
            return html;
        }

        // Drag-to-reorder credit lines
        function initCreditDrag(container) {
            var lines = container.querySelectorAll('.credit-line');
            lines.forEach(function(line) {
                if (line._dragInit) return;
                line._dragInit = true;
                line.addEventListener('dragstart', function(e) {
                    line.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', '');
                });
                line.addEventListener('dragend', function() {
                    line.classList.remove('dragging');
                    container.querySelectorAll('.credit-line').forEach(function(l) { l.classList.remove('drag-over'); });
                });
                line.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    container.querySelectorAll('.credit-line').forEach(function(l) { l.classList.remove('drag-over'); });
                    var dragging = container.querySelector('.credit-line.dragging');
                    if (dragging && line !== dragging) line.classList.add('drag-over');
                });
                line.addEventListener('drop', function(e) {
                    e.preventDefault();
                    var dragging = container.querySelector('.credit-line.dragging');
                    if (dragging && line !== dragging) {
                        var allLines = Array.from(container.querySelectorAll('.credit-line'));
                        var fromIdx = allLines.indexOf(dragging);
                        var toIdx = allLines.indexOf(line);
                        if (fromIdx < toIdx) {
                            container.insertBefore(dragging, line.nextSibling);
                        } else {
                            container.insertBefore(dragging, line);
                        }
                    }
                    container.querySelectorAll('.credit-line').forEach(function(l) { l.classList.remove('drag-over'); });
                });
            });
        }

        // Hook into form submissions to gather credits
        document.addEventListener('submit', function(e) {
            var form = e.target;
            if (form.id === 'addForm') {
                document.getElementById('addCreditsHidden').value = gatherCreditsHtml('addCreditsEditor');
            } else if (form.id === 'editForm') {
                document.getElementById('editCreditsHidden').value = gatherCreditsHtml('editCreditsEditor');
            }
        });

        // Initialize role tags on page load for the add modal
        document.addEventListener('DOMContentLoaded', function() {
            renderRoleTags('addCreditsEditor');
        });
    </script>
</body>
</html>
