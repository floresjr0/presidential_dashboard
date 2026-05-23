<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['mis','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$pageTitle  = 'MIS Dashboard';
$sidebarNav = misNav();
$user       = currentUser();
$db         = getDB();

$stats = [
    'system_users' => $db->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'],
    'campuses'     => $db->query("SELECT COUNT(*) c FROM campuses")->fetch_assoc()['c'],
    'logs_today'   => $db->query("SELECT COUNT(*) c FROM audit_logs WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['c'],
];

require __DIR__ . '/../../includes/layout.php';
?>

<?php
$statsContext = 'mis';
require __DIR__ . '/../../includes/stats_cards.php';
?>

<div class="quick-actions">
    <a href="<?= APP_URL ?>/modules/mis/campuses.php" class="btn btn-primary">Manage Campuses</a>
    <a href="<?= APP_URL ?>/modules/admin/logs.php" class="btn btn-outline">Audit Logs</a>
    <a href="<?= APP_URL ?>/install.php" class="btn btn-outline">Re-run Installer</a>
</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>