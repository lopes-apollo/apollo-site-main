<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

// If already logged in, redirect
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo CMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: var(--bg-primary);
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container > div {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 50px;
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header h1 {
            color: var(--text-primary);
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }
        .login-header h1 i {
            margin-right: 12px;
            opacity: 0.9;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .input-group-text {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-right: none;
            color: var(--text-secondary);
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--accent);
            color: var(--accent);
        }
        .input-group:focus-within .form-control {
            border-color: var(--accent);
        }
        .btn-login {
            background: var(--accent);
            color: var(--bg-primary);
            border: 1px solid var(--accent);
            border-radius: 0;
            padding: 14px;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            color: var(--bg-primary);
            transform: translateY(-1px);
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
            color: var(--danger);
            border-radius: 0;
            border: 1px solid;
            padding: 14px 18px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div>
                <div class="login-header">
                    <a href="../index.php" title="Go to Website" style="display: block; margin-bottom: 20px;">
                        <img src="../fonts/logo.png" alt="Apollo" style="max-width: 60px; height: auto; margin: 0 auto; display: block;">
                    </a>
                    <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">Content Management System</p>
                </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
