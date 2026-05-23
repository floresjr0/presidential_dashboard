<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/includes/nav.php';

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
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/login.css">
</head>
<body class="login-page">
    <div class="login-wrapper">

        <div class="login-panel">
            <div class="panel-badge">
                <span class="badge-dot"></span>
                <?= e(APP_NAME) ?>
            </div>
            <h1 class="panel-title">
                One dashboard.<br>
                <span class="panel-title-accent">Full visibility.</span>
            </h1>
            <p class="panel-desc">
                Monitor enrollment, finance, research, and staff across all campuses &mdash; in one place.
            </p>
            <ul class="panel-features">
                <?php foreach (loginPanelFeatures() as $feat): ?>
                <li class="panel-feat">
                    <span class="feat-icon"><?= $feat['icon'] ?></span>
                    <?= htmlspecialchars($feat['label']) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="login-form-area">
            <div class="login-logo">UD</div>
            <h2 class="form-heading">Welcome back</h2>
            <p class="form-subheading">Sign in to access your dashboard</p>
            <form method="POST" novalidate>
                <?php if ($error): ?>
                <div class="flash flash-error"><?= e($error) ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus autocomplete="username" placeholder="e.g. admin">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
            </form>
            <p class="text-muted" style="font-size:.8rem;text-align:center;margin-top:18px;">
                First time? <a href="<?= APP_URL ?>/install.php"><strong>Run installer</strong></a>
            </p>
        </div>

    </div>
</body>
</html>