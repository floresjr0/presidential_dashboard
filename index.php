<?php
require_once __DIR__ . '/config/app.php';

if (isLoggedIn()) {
    redirect(roleDashboardPath($_SESSION['role']));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = getDB()->prepare('SELECT * FROM users WHERE username = ? AND status = ?');
    $active = 'active';
    $stmt->bind_param('ss', $username, $active);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        loginUser($user);
        redirect(roleDashboardPath($user['role']));
    }
    $error = 'Invalid username or password.';
    auditLog('login_failed', 'auth', null, "Failed login: $username");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-logo">UD</div>
        <h1><?= e(APP_NAME) ?></h1>
        <p class="subtitle">Executive monitoring & institutional data portal</p>
        <?php if ($error): ?><div class="flash flash-error" style="margin-bottom:16px;border-radius:8px;"><?= e($error) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus placeholder="e.g. admin">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
        </form>
        <p class="text-muted mt-2" style="font-size:.8rem;text-align:center;margin-top:20px;">
            First time? <a href="<?= APP_URL ?>/install.php">Run installer</a>
        </p>
    </div>
</body>
</html>
