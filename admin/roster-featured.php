<?php
require_once 'config.php';
requireLogin();

$featured = getRosterFeatured();
$allVideos = getVideos();
$artists = getArtists();
$message = '';

$artists_by_id = [];
foreach ($artists as $a) {
    $artists_by_id[$a['id']] = $a;
}

$videos_by_id = [];
foreach ($allVideos as $v) {
    $videos_by_id[$v['id']] = $v;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $dept = $_POST['dept'] ?? '';
        $video_ids = $_POST['video_ids'] ?? [];
        if (in_array($dept, ['EDIT', 'COLOR', 'SOUND', 'VFX'])) {
            $video_ids = array_values(array_filter($video_ids, function($id) use ($videos_by_id) {
                return isset($videos_by_id[$id]);
            }));
            $featured[$dept] = $video_ids;
            saveRosterFeatured($featured);
            $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> <strong>' . $dept . ' roster videos saved!</strong> ' . count($video_ids) . ' video(s) selected.</div>';
        }
    }

    clearCache();
    $featured = getRosterFeatured();
}

$activeDept = $_GET['dept'] ?? 'EDIT';
if (!in_array($activeDept, ['EDIT', 'COLOR', 'SOUND', 'VFX'])) $activeDept = 'EDIT';
$deptLabels = ['EDIT' => 'Edit', 'COLOR' => 'Color', 'SOUND' => 'Sound', 'VFX' => 'VFX'];

$deptVideoCounts = ['EDIT' => 0, 'COLOR' => 0, 'SOUND' => 0, 'VFX' => 0];
foreach ($allVideos as $v) {
    foreach ($v['tags'] ?? [] as $t) {
        if (isset($deptVideoCounts[$t])) $deptVideoCounts[$t]++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roster Videos - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .dept-tabs { display:flex; gap:0; border-bottom:1px solid var(--border); margin-bottom:24px; }
        .dept-tab { padding:12px 28px; font-size:13px; font-weight:600; letter-spacing:1px; color:var(--text-3); cursor:pointer; border-bottom:2px solid transparent; transition:all .2s; text-decoration:none; }
        .dept-tab:hover { color:var(--text-1); }
        .dept-tab.active { color:var(--text-1); border-bottom-color:var(--accent, #fff); }
        .dept-tab .badge { font-size:10px; padding:2px 7px; margin-left:6px; border-radius:10px; background:rgba(255,255,255,.12); color:rgba(255,255,255,.7); font-weight:600; }
        .dept-tab.active .badge { background:#fff; color:#000; font-weight:700; }

        .rf-layout { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
        @media(max-width:992px) { .rf-layout { grid-template-columns:1fr; } }

        .rf-panel { background:var(--bg-secondary, #1a1a1a); border:1px solid var(--border); border-radius:8px; padding:20px; }
        .rf-panel-title { font-size:12px; font-weight:600; letter-spacing:1px; color:var(--text-3); text-transform:uppercase; margin-bottom:14px; }

        .rf-search { position:relative; margin-bottom:12px; }
        .rf-search input { padding-left:36px; background:var(--bg-primary, #111); border:1px solid var(--border); color:var(--text-1); font-size:13px; border-radius:6px; width:100%; padding:10px 12px 10px 36px; }
        .rf-search input:focus { outline:none; border-color:var(--text-3); }
        .rf-search i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-3); font-size:12px; }

        .rf-pool { max-height:600px; overflow-y:auto; display:flex; flex-direction:column; gap:4px; }
        .rf-pool-item { display:flex; align-items:center; gap:12px; padding:8px 10px; border-radius:6px; cursor:pointer; transition:background .15s; }
        .rf-pool-item:hover { background:rgba(255,255,255,.04); }
        .rf-pool-item.in-list { opacity:.35; pointer-events:none; }
        .rf-pool-item img { width:56px; height:36px; object-fit:cover; border-radius:3px; flex-shrink:0; }
        .rf-pool-item .rf-pi-placeholder { width:56px; height:36px; border-radius:3px; flex-shrink:0; background:var(--bg-primary, #111); display:flex; align-items:center; justify-content:center; }
        .rf-pool-item .rf-pi-info { flex:1; min-width:0; }
        .rf-pool-item .rf-pi-title { font-size:12.5px; font-weight:500; color:var(--text-1); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rf-pool-item .rf-pi-sub { font-size:11px; color:var(--text-3); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rf-pool-item .rf-pi-add { flex-shrink:0; font-size:14px; color:var(--text-3); opacity:0; transition:opacity .15s; }
        .rf-pool-item:hover .rf-pi-add { opacity:1; }

        .rf-selected { min-height:120px; display:flex; flex-direction:column; gap:4px; }
        .rf-selected-empty { text-align:center; padding:40px 20px; color:var(--text-3); font-size:13px; }
        .rf-selected-empty i { font-size:24px; display:block; margin-bottom:8px; opacity:.4; }

        .rf-sel-item { display:flex; align-items:center; gap:12px; padding:8px 10px; border-radius:6px; background:rgba(255,255,255,.03); border:1px solid var(--border); }
        .rf-sel-item img { width:56px; height:36px; object-fit:cover; border-radius:3px; flex-shrink:0; }
        .rf-sel-item .rf-si-placeholder { width:56px; height:36px; border-radius:3px; flex-shrink:0; background:var(--bg-primary, #111); display:flex; align-items:center; justify-content:center; }
        .rf-sel-item .rf-si-num { width:22px; text-align:center; font-size:11px; font-weight:600; color:var(--text-3); flex-shrink:0; }
        .rf-sel-item .rf-si-info { flex:1; min-width:0; }
        .rf-sel-item .rf-si-title { font-size:12.5px; font-weight:500; color:var(--text-1); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rf-sel-item .rf-si-sub { font-size:11px; color:var(--text-3); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rf-sel-item .rf-si-actions { flex-shrink:0; display:flex; gap:4px; }
        .rf-sel-item .rf-si-actions button { background:none; border:none; color:var(--text-3); cursor:pointer; padding:4px 6px; font-size:11px; border-radius:4px; transition:all .15s; }
        .rf-sel-item .rf-si-actions button:hover { background:rgba(255,255,255,.08); color:var(--text-1); }
        .rf-sel-item .rf-si-actions .rf-remove:hover { color:#e55; }

        .rf-save-bar { display:flex; align-items:center; justify-content:space-between; margin-top:16px; padding-top:16px; border-top:1px solid var(--border); }
        .rf-save-bar .rf-count { font-size:12px; color:var(--text-3); }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-th-large"></i> Roster Videos</h1>
            <p style="color:var(--text-3); font-size:13px; margin:0;">Pick and order videos for the horizontal scrolling roster page. Empty departments show all artist videos by default.</p>
        </div>

        <?php echo $message; ?>

        <div class="dept-tabs">
            <?php foreach ($deptLabels as $key => $label): ?>
                <a href="?dept=<?php echo $key; ?>" class="dept-tab <?php echo $activeDept === $key ? 'active' : ''; ?>">
                    <?php echo $label; ?>
                    <span class="badge"><?php echo $deptVideoCounts[$key]; ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <form method="POST" id="rosterFeaturedForm">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="dept" value="<?php echo $activeDept; ?>">

            <div class="rf-layout">
                <div class="rf-panel">
                    <div class="rf-panel-title"><i class="fas fa-database" style="margin-right:6px;"></i><?php echo $deptLabels[$activeDept]; ?> Videos</div>
                    <div class="rf-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="poolSearch" placeholder="Search videos..." oninput="filterPool()">
                    </div>
                    <div class="rf-pool" id="poolList">
                        <?php foreach ($allVideos as $v):
                            $tags = $v['tags'] ?? [];
                            if (!in_array($activeDept, $tags)) continue;
                            $inList = in_array($v['id'], $featured[$activeDept] ?? []);
                            $artistName = '';
                            foreach ($artists as $a) {
                                if (in_array($v['id'], $a['video_ids'] ?? [])) {
                                    $artistName = $a['name'];
                                    break;
                                }
                            }
                        ?>
                        <div class="rf-pool-item <?php echo $inList ? 'in-list' : ''; ?>"
                             data-vid="<?php echo htmlspecialchars($v['id']); ?>"
                             data-title="<?php echo htmlspecialchars($v['title'] ?? ''); ?>"
                             data-subtitle="<?php echo htmlspecialchars($v['subtitle'] ?? ''); ?>"
                             data-poster="<?php echo htmlspecialchars($v['poster'] ?? ''); ?>"
                             data-artist="<?php echo htmlspecialchars($artistName); ?>"
                             onclick="addVideo(this)">
                            <?php if (!empty($v['poster'])): ?>
                                <img src="../roster/<?php echo htmlspecialchars($v['poster']); ?>" alt="" loading="lazy">
                            <?php else: ?>
                                <div class="rf-pi-placeholder"><i class="fas fa-film" style="color:var(--text-3);font-size:10px;"></i></div>
                            <?php endif; ?>
                            <div class="rf-pi-info">
                                <div class="rf-pi-title"><?php echo htmlspecialchars($v['title'] ?? 'Untitled'); ?></div>
                                <div class="rf-pi-sub"><?php echo htmlspecialchars($v['subtitle'] ?? ''); ?><?php if ($artistName): ?> &middot; <?php echo htmlspecialchars($artistName); ?><?php endif; ?></div>
                            </div>
                            <div class="rf-pi-add"><i class="fas fa-plus"></i></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="rf-panel">
                    <div class="rf-panel-title"><i class="fas fa-star" style="margin-right:6px;"></i><?php echo $deptLabels[$activeDept]; ?> &mdash; Selected Videos</div>
                    <div class="rf-selected" id="selectedList">
                        <?php
                        $deptVids = $featured[$activeDept] ?? [];
                        if (empty($deptVids)):
                        ?>
                            <div class="rf-selected-empty" id="emptyMsg">
                                <i class="fas fa-hand-pointer"></i>
                                Click videos from the pool to add them here.<br>
                                <small>All artist videos will be shown if this list is empty.</small>
                            </div>
                        <?php else:
                            foreach ($deptVids as $idx => $vid_id):
                                $v = $videos_by_id[$vid_id] ?? null;
                                if (!$v) continue;
                        ?>
                            <div class="rf-sel-item" data-vid="<?php echo htmlspecialchars($vid_id); ?>">
                                <span class="rf-si-num"><?php echo $idx + 1; ?></span>
                                <?php if (!empty($v['poster'])): ?>
                                    <img src="../roster/<?php echo htmlspecialchars($v['poster']); ?>" alt="" loading="lazy">
                                <?php else: ?>
                                    <div class="rf-si-placeholder"><i class="fas fa-film" style="color:var(--text-3);font-size:10px;"></i></div>
                                <?php endif; ?>
                                <div class="rf-si-info">
                                    <div class="rf-si-title"><?php echo htmlspecialchars($v['title'] ?? 'Untitled'); ?></div>
                                    <div class="rf-si-sub"><?php echo htmlspecialchars($v['subtitle'] ?? ''); ?></div>
                                </div>
                                <div class="rf-si-actions">
                                    <button type="button" onclick="moveItem(this,-1)" title="Move up"><i class="fas fa-chevron-up"></i></button>
                                    <button type="button" onclick="moveItem(this,1)" title="Move down"><i class="fas fa-chevron-down"></i></button>
                                    <button type="button" class="rf-remove" onclick="removeItem(this)" title="Remove"><i class="fas fa-times"></i></button>
                                </div>
                                <input type="hidden" name="video_ids[]" value="<?php echo htmlspecialchars($vid_id); ?>">
                            </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="rf-save-bar">
                        <span class="rf-count" id="countLabel"><?php echo count($deptVids); ?> video(s) selected</span>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save <?php echo $deptLabels[$activeDept]; ?> Videos</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    var poolData = <?php echo json_encode(array_map(function($v) {
        return ['id' => $v['id'], 'title' => $v['title'] ?? '', 'subtitle' => $v['subtitle'] ?? '', 'poster' => $v['poster'] ?? ''];
    }, $allVideos)); ?>;

    function getSelectedIds() {
        var ids = [];
        document.querySelectorAll('#selectedList .rf-sel-item').forEach(function(el) {
            ids.push(el.dataset.vid);
        });
        return ids;
    }

    function refreshNumbers() {
        var items = document.querySelectorAll('#selectedList .rf-sel-item');
        var count = items.length;
        items.forEach(function(el, i) {
            el.querySelector('.rf-si-num').textContent = i + 1;
        });
        document.getElementById('countLabel').textContent = count + ' video(s) selected';

        var emptyMsg = document.getElementById('emptyMsg');
        if (count === 0 && !emptyMsg) {
            document.getElementById('selectedList').innerHTML =
                '<div class="rf-selected-empty" id="emptyMsg">' +
                '<i class="fas fa-hand-pointer"></i>' +
                'Click videos from the pool to add them here.<br>' +
                '<small>All artist videos will be shown if this list is empty.</small>' +
                '</div>';
        } else if (count > 0 && emptyMsg) {
            emptyMsg.remove();
        }

        var ids = getSelectedIds();
        document.querySelectorAll('#poolList .rf-pool-item').forEach(function(el) {
            el.classList.toggle('in-list', ids.indexOf(el.dataset.vid) !== -1);
        });
    }

    function addVideo(poolEl) {
        if (poolEl.classList.contains('in-list')) return;
        var vid = poolEl.dataset.vid;
        var title = poolEl.dataset.title;
        var subtitle = poolEl.dataset.subtitle;
        var poster = poolEl.dataset.poster;

        var emptyMsg = document.getElementById('emptyMsg');
        if (emptyMsg) emptyMsg.remove();

        var thumbHtml = poster
            ? '<img src="../roster/' + escapeHtml(poster) + '" alt="" loading="lazy">'
            : '<div class="rf-si-placeholder"><i class="fas fa-film" style="color:var(--text-3);font-size:10px;"></i></div>';

        var html =
            '<div class="rf-sel-item" data-vid="' + escapeHtml(vid) + '">' +
            '<span class="rf-si-num"></span>' +
            thumbHtml +
            '<div class="rf-si-info">' +
            '<div class="rf-si-title">' + escapeHtml(title) + '</div>' +
            '<div class="rf-si-sub">' + escapeHtml(subtitle) + '</div>' +
            '</div>' +
            '<div class="rf-si-actions">' +
            '<button type="button" onclick="moveItem(this,-1)" title="Move up"><i class="fas fa-chevron-up"></i></button>' +
            '<button type="button" onclick="moveItem(this,1)" title="Move down"><i class="fas fa-chevron-down"></i></button>' +
            '<button type="button" class="rf-remove" onclick="removeItem(this)" title="Remove"><i class="fas fa-times"></i></button>' +
            '</div>' +
            '<input type="hidden" name="video_ids[]" value="' + escapeHtml(vid) + '">' +
            '</div>';

        document.getElementById('selectedList').insertAdjacentHTML('beforeend', html);
        refreshNumbers();
    }

    function removeItem(btn) {
        btn.closest('.rf-sel-item').remove();
        refreshNumbers();
    }

    function moveItem(btn, dir) {
        var item = btn.closest('.rf-sel-item');
        var list = item.parentNode;
        var items = Array.from(list.querySelectorAll('.rf-sel-item'));
        var idx = items.indexOf(item);
        if (dir === -1 && idx > 0) {
            list.insertBefore(item, items[idx - 1]);
        } else if (dir === 1 && idx < items.length - 1) {
            list.insertBefore(items[idx + 1], item);
        }
        refreshNumbers();
    }

    function filterPool() {
        var q = document.getElementById('poolSearch').value.toLowerCase();
        document.querySelectorAll('#poolList .rf-pool-item').forEach(function(el) {
            var t = (el.dataset.title || '').toLowerCase();
            var s = (el.dataset.subtitle || '').toLowerCase();
            var a = (el.dataset.artist || '').toLowerCase();
            el.style.display = (t.indexOf(q) !== -1 || s.indexOf(q) !== -1 || a.indexOf(q) !== -1) ? '' : 'none';
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }
    </script>
</body>
</html>
