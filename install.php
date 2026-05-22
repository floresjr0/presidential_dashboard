<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'university_dashboard';
$steps = [];

try {
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) throw new Exception($conn->connect_error);

    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $seed = file_get_contents(__DIR__ . '/database/seed.sql');

    if ($conn->multi_query($schema)) {
        do { if ($r = $conn->store_result()) $r->free(); } while ($conn->more_results() && $conn->next_result());
        $steps[] = ['ok', 'Database schema created'];
    } else {
        $steps[] = ['err', 'Schema error: ' . $conn->error];
    }

    $conn->select_db($dbName);
    if ($conn->multi_query($seed)) {
        do { if ($r = $conn->store_result()) $r->free(); } while ($conn->more_results() && $conn->next_result());
        $steps[] = ['ok', 'Seed data loaded'];
    } else {
        $steps[] = ['err', 'Seed error: ' . $conn->error];
    }

    if (!is_dir(__DIR__ . '/uploads/research')) {
        mkdir(__DIR__ . '/uploads/research', 0755, true);
        $steps[] = ['ok', 'Upload directory created'];
    }

    $steps[] = ['ok', 'Installation complete! Default password: password123'];
    $done = true;
} catch (Exception $e) {
    $steps[] = ['err', $e->getMessage()];
    $done = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - University Dashboard</title>
    <link rel="stylesheet" href="/university_dashboard/assets/css/style.css">
</head>
<body>
<div class="install-page">
    <div class="install-steps">
        <h2>University Dashboard Installation</h2>
        <?php foreach ($steps as $s): ?>
        <div class="step <?= $s[0] ?>"><?= $s[0] === 'ok' ? '✓' : '✗' ?> <?= htmlspecialchars($s[1]) ?></div>
        <?php endforeach; ?>
        <?php if (!empty($done)): ?>
        <p class="mt-2"><a href="/university_dashboard/index.php" class="btn btn-primary">Go to Login</a></p>
        <p class="text-muted mt-2">Demo accounts: admin, president, registrar, finance, research, hr, depthead, campusadmin, guidance, mis — password: <strong>password123</strong></p>
        <?php else: ?>
        <p class="mt-2 text-muted">Ensure XAMPP MySQL is running, then refresh this page.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
