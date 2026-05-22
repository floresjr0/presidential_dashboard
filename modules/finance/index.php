<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['finance','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$db = getDB();
$rev = $db->query("SELECT SUM(amount) as t FROM finance_records WHERE record_type='revenue'")->fetch_assoc()['t'] ?? 0;
$exp = $db->query("SELECT SUM(amount) as t FROM finance_records WHERE record_type='expense'")->fetch_assoc()['t'] ?? 0;
$pageTitle = 'Finance Dashboard';
$sidebarNav = financeNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card success"><div class="label">Total Revenue</div><div class="value">₱<?= number_format($rev,2) ?></div></div>
    <div class="stat-card danger"><div class="label">Total Expenses</div><div class="value">₱<?= number_format($exp,2) ?></div></div>
    <div class="stat-card"><div class="label">Net Balance</div><div class="value">₱<?= number_format($rev-$exp,2) ?></div></div>
</div>
<a href="<?= APP_URL ?>/modules/finance/records.php" class="btn btn-primary">Manage Financial Records</a>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
