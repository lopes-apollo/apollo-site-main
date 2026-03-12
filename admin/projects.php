<?php
require_once 'config.php';
requireLogin();

$projects = getProjects();
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
                $_POST['prev1'] ?? '',
                $_POST['prev2'] ?? '',
                $_POST['prev3'] ?? '',
                $_POST['prev4'] ?? '',
                $_POST['prev5'] ?? '',
                $_POST['prev6'] ?? ''
            ],
            'order' => intval($_POST['order'] ?? count($projects)),
            'visible' => isset($_POST['visible'])
        ];
        
        // Update or add
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
        
        saveProjects($projects);
        $message = '<div class="alert alert-success">Project saved successfully!</div>';
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $projects = array_filter($projects, function($p) use ($id) {
            return $p['id'] !== $id;
        });
        saveProjects(array_values($projects));
        $message = '<div class="alert alert-success">Project deleted successfully!</div>';
    }
    
    $projects = getProjects();
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
    <title>Projects - Apollo CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-film"></i> Projects</h1>
            <a href="?action=add" class="btn-primary"><i class="fas fa-plus"></i> Add Project</a>
        </div>
        
        <?php echo $message; ?>
        
        <?php if ($editing || isset($_GET['action']) && $_GET['action'] === 'add'): ?>
            <!-- Edit/Add Form -->
            <div class="content-card">
                <h2><?php echo $editing ? 'Edit Project' : 'Add New Project'; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo $editing['id'] ?? ''; ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" 
                                       value="<?php echo htmlspecialchars($editing['title'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" 
                                       value="<?php echo htmlspecialchars($editing['subtitle'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category/Author *</label>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Image Class</label>
                                <input type="text" class="form-control" name="image_class" 
                                       value="<?php echo htmlspecialchars($editing['image_class'] ?? 'bgimage' . (count($projects) + 1)); ?>">
                                <small class="text-muted">CSS class for background image (e.g., bgimage8)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Short Video (Preview) *</label>
                                <input type="text" class="form-control" name="video_short" 
                                       value="<?php echo htmlspecialchars($editing['video_short'] ?? ''); ?>" required>
                                <small class="text-muted">Path to short video (e.g., roster/videos/short/compressed/trexx cover-1080p.mp4)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Long Video (Full) *</label>
                                <input type="text" class="form-control" name="video_long" 
                                       value="<?php echo htmlspecialchars($editing['video_long'] ?? ''); ?>" required>
                                <small class="text-muted">Full video URL (embedded or local path)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Preview Images (up to 6)</label>
                        <div class="row">
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <div class="col-md-4 mb-2">
                                    <input type="text" class="form-control" name="prev<?php echo $i; ?>" 
                                           placeholder="Preview Image <?php echo $i; ?>" 
                                           value="<?php echo htmlspecialchars($editing['preview_images'][$i-1] ?? ''); ?>">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
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
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Project</button>
                        <a href="projects.php" class="btn btn-secondary">Cancel</a>
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
</body>
</html>
