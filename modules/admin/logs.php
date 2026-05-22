<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['admin','mis']);
require_once __DIR__ . '/../../includes/nav.php';
$sidebarNav = ($_SESSION['role'] ?? '') === 'mis' ? misNav() : adminNav();
$logs = getDB()->query("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 200");
$pageTitle = 'Audit Logs';
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Time</th><th>User</th><th>Action</th><th>Module</th><th>Details</th><th>IP</th></tr></thead><tbody>
<?php while ($l = $logs->fetch_assoc()): ?>
<tr><td><?= e($l['created_at']) ?></td><td><?= e($l['username']) ?></td><td><?= e($l['action']) ?></td><td><?= e($l['module']) ?></td><td><?= e($l['details']) ?></td><td><?= e($l['ip_address']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
