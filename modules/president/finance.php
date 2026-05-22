<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['president','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$db = getDB();
$records = $db->query("SELECT f.*, c.name as campus_name FROM finance_records f LEFT JOIN campuses c ON f.campus_id = c.id ORDER BY f.record_date DESC LIMIT 50");
$pageTitle = 'Finance Overview';
$sidebarNav = presidentNav();
$user = currentUser();
$stats = getDashboardStats();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card success"><div class="label">Total Revenue</div><div class="value">₱<?= number_format($stats['revenue'],2) ?></div></div>
    <div class="stat-card danger"><div class="label">Total Expenses</div><div class="value">₱<?= number_format($stats['expenses'],2) ?></div></div>
    <div class="stat-card"><div class="label">Net</div><div class="value">₱<?= number_format($stats['revenue']-$stats['expenses'],2) ?></div></div>
</div>
<div class="card"><div class="card-header">Recent Financial Records</div><div class="card-body table-wrap">
<table><thead><tr><th>Date</th><th>Type</th><th>Title</th><th>Amount</th><th>Campus</th></tr></thead><tbody>
<?php while ($r = $records->fetch_assoc()): ?>
<tr><td><?= e($r['record_date']) ?></td><td><span class="badge badge-<?= $r['record_type']==='revenue'?'success':'danger' ?>"><?= e($r['record_type']) ?></span></td><td><?= e($r['title']) ?></td><td>₱<?= number_format($r['amount'],2) ?></td><td><?= e($r['campus_name'] ?? 'All') ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
