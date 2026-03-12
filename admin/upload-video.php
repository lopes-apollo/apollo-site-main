<?php
require_once 'config.php';
requireLogin();

error_reporting(0);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$type = $_POST['type'] ?? '';
$allowed_types = ['video', 'poster'];

if (!in_array($type, $allowed_types)) {
    echo json_encode(['success' => false, 'error' => 'Invalid upload type']);
    exit;
}

$file = $_FILES['file'] ?? null;
if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    $error_messages = [
        UPLOAD_ERR_INI_SIZE => 'File exceeds server upload limit',
        UPLOAD_ERR_FORM_SIZE => 'File exceeds form upload limit',
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
    ];
    $err_code = $file['error'] ?? UPLOAD_ERR_NO_FILE;
    $msg = $error_messages[$err_code] ?? 'Unknown upload error';
    echo json_encode(['success' => false, 'error' => $msg]);
    exit;
}

$max_size = 100 * 1024 * 1024; // 100MB
if ($file['size'] > $max_size) {
    echo json_encode(['success' => false, 'error' => 'File too large (max 100MB)']);
    exit;
}

if ($type === 'video') {
    $allowed_extensions = ['mp4', 'webm', 'mov'];
    $allowed_mimes = ['video/mp4', 'video/webm', 'video/quicktime'];
    $upload_dir = __DIR__ . '/../roster/videos/short/';
    $path_prefix = 'videos/short/';
} else {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];
    $upload_dir = __DIR__ . '/../roster/videos/images/';
    $path_prefix = 'videos/images/';
}

$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($extension, $allowed_extensions)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowed_extensions)]);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);

if (!in_array($mime, $allowed_mimes)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file content type: ' . $mime]);
    exit;
}

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

$original_name = pathinfo($file['name'], PATHINFO_FILENAME);
$safe_name = preg_replace('/[^a-zA-Z0-9_\-]/', '-', $original_name);
$safe_name = preg_replace('/-+/', '-', $safe_name);
$safe_name = trim($safe_name, '-');

$filename = $safe_name . '.' . $extension;
$dest = $upload_dir . $filename;

if (file_exists($dest)) {
    $filename = $safe_name . '_' . time() . '.' . $extension;
    $dest = $upload_dir . $filename;
}

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
    exit;
}

chmod($dest, 0644);

$relative_path = $path_prefix . $filename;

echo json_encode([
    'success' => true,
    'path' => $relative_path,
    'filename' => $filename,
    'size' => $file['size'],
    'size_formatted' => formatFileSize($file['size'])
]);

function formatFileSize($bytes) {
    if ($bytes == 0) return '0 B';
    $k = 1024;
    $sizes = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
