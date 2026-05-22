<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['mis','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$pageTitle = 'MIS Dashboard';
$sidebarNav = misNav();
$user = currentUser();
$db = getDB();
$users = $db->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'];
$campuses = $db->query("SELECT COUNT(*) c FROM campuses")->fetch_assoc()['c'];
$logs = $db->query("SELECT COUNT(*) c FROM audit_logs WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['c'];
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card"><div class="label">System Users</div><div class="value"><?= $users ?></div></div>
    <div class="stat-card"><div class="label">Campuses</div><div class="value"><?= $campuses ?></div></div>
    <div class="stat-card warning"><div class="label">Logs Today</div><div class="value"><?= $logs ?></div></div>
</div>
<div style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="<?= APP_URL ?>/modules/mis/campuses.php" class="btn btn-primary">Manage Campuses</a>
    <a href="<?= APP_URL ?>/modules/admin/logs.php" class="btn btn-outline">Audit Logs</a>
    <a href="<?= APP_URL ?>/install.php" class="btn btn-outline">Re-run Installer</a>
</div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
