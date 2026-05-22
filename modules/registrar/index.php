<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['registrar','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats = getDashboardStats();
$pageTitle = 'Registrar Dashboard';
$sidebarNav = registrarNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card"><div class="label">Enrolled</div><div class="value"><?= $stats['enrolled'] ?></div></div>
    <div class="stat-card accent"><div class="label">Graduating</div><div class="value"><?= $stats['graduating'] ?></div></div>
    <div class="stat-card warning"><div class="label">BASCAT</div><div class="value"><?= $stats['bascat'] ?></div></div>
    <div class="stat-card danger"><div class="label">Dropped</div><div class="value"><?= $stats['dropped'] ?></div></div>
</div>
<a href="<?= APP_URL ?>/modules/registrar/enrollment.php" class="btn btn-primary">Input Enrollment Statistics</a>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
