<?php
$user = currentUser();
$flash = getFlash();
$pageTitle = $pageTitle ?? 'Dashboard';

$currentPath = $_SERVER['SCRIPT_FILENAME'] ?? '';
if (!isset($pageCSS)) {
if (str_contains($currentPath, '/modules/admin/users.php')) {
    $pageCSS = 'modules/admin/users.css';
} elseif (str_contains($currentPath, '/modules/admin/logs.php')) {
    $pageCSS = 'modules/admin/logs.css';
} elseif (str_contains($currentPath, '/modules/admin/')) {
    $pageCSS = 'modules/admin/index.css';
} elseif (str_contains($currentPath, '/modules/president/population.php')) {
    $pageCSS = 'modules/president/population.css';
} elseif (str_contains($currentPath, '/modules/president/')) {
    $pageCSS = 'modules/president/index.css';
} elseif (str_contains($currentPath, '/modules/finance/records.php')) {
    $pageCSS = 'modules/finance/records.css';
} elseif (str_contains($currentPath, '/modules/finance/')) {
    $pageCSS = 'modules/finance/index.css';
} elseif (str_contains($currentPath, '/modules/registrar/enrollment.php')) {
    $pageCSS = 'modules/registrar/enrollment.css';
} elseif (str_contains($currentPath, '/modules/registrar/students.php')) {
    $pageCSS = 'modules/registrar/students.css';
} elseif (str_contains($currentPath, '/modules/registrar/')) {
    $pageCSS = 'modules/registrar/index.css';
} elseif (str_contains($currentPath, '/modules/research/documents.php')) {
    $pageCSS = 'modules/research/documents.css';
} elseif (str_contains($currentPath, '/modules/research/library.php')) {
    $pageCSS = 'modules/research/library.css';
} elseif (str_contains($currentPath, '/modules/research/')) {
    $pageCSS = 'modules/research/index.css';
} elseif (str_contains($currentPath, '/modules/campus/')) {
    $pageCSS = 'modules/campus/index.css';
} elseif (str_contains($currentPath, '/modules/department/employees.php')) {
    $pageCSS = 'modules/department/employees.css';
} elseif (str_contains($currentPath, '/modules/department/')) {
    $pageCSS = 'modules/department/index.css';
} elseif (str_contains($currentPath, '/modules/guidance/')) {
    $pageCSS = 'modules/guidance/index.css';
} elseif (str_contains($currentPath, '/modules/hr/')) {
    $pageCSS = 'modules/hr/index.css';
} elseif (str_contains($currentPath, '/modules/mis/campuses.php')) {
    $pageCSS = 'modules/mis/campuses.css';
} elseif (str_contains($currentPath, '/modules/mis/')) {
    $pageCSS = 'modules/mis/index.css';
} else {
    $pageCSS = 'modules/admin/index.css';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/<?= $pageCSS ?>?v=<?= filemtime(__DIR__ . '/../assets/css/' . $pageCSS) ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>
<?php if ($flash): ?>
<div class="flash flash-<?= e($flash['type']) ?>" id="flash-msg"><?= e($flash['message']) ?></div>
<?php endif; ?>