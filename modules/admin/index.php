<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats = getDashboardStats();
$pageTitle = 'Admin Dashboard';
$sidebarNav = adminNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>
<div class="card"><div class="card-header">Quick Actions</div><div class="card-body" style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="<?= APP_URL ?>/modules/admin/users.php" class="btn btn-primary">Manage Users</a>
    <a href="<?= APP_URL ?>/modules/admin/announcements.php" class="btn btn-accent">Post Announcement</a>
    <a href="<?= APP_URL ?>/modules/president/index.php" class="btn btn-outline">Executive View</a>
    <a href="<?= APP_URL ?>/modules/admin/logs.php" class="btn btn-outline">Audit Logs</a>
</div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
