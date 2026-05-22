<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['hr','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats = getDashboardStats();
$pageTitle = 'HR Dashboard';
$sidebarNav = hrNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card"><div class="label">Instructors</div><div class="value"><?= $stats['instructors'] ?></div></div>
    <div class="stat-card"><div class="label">Non-Teaching</div><div class="value"><?= $stats['non_teaching'] ?></div></div>
    <div class="stat-card"><div class="label">Administrative</div><div class="value"><?= $stats['admin_staff'] ?></div></div>
</div>
<a href="<?= APP_URL ?>/modules/hr/employees.php" class="btn btn-primary">Manage Employees</a>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
