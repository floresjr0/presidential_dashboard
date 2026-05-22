<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['mis','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT c.*, (SELECT COUNT(*) FROM institutes i WHERE i.campus_id=c.id) as institutes, (SELECT COUNT(*) FROM courses co WHERE co.campus_id=c.id) as courses FROM campuses c ORDER BY c.name");
$pageTitle = 'Campus Management';
$sidebarNav = misNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'campusModal\')">+ Add Campus</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Code</th><th>Name</th><th>Institutes</th><th>Courses</th><th>Status</th></tr></thead><tbody>
<?php while ($c = $rows->fetch_assoc()): ?>
<tr><td><?= e($c['code']) ?></td><td><?= e($c['name']) ?></td><td><?= $c['institutes'] ?></td><td><?= $c['courses'] ?></td><td><?= e($c['status']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="campusModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_campus">
<div class="modal-header"><h3>Add Campus</h3><button type="button" onclick="closeModal('campusModal')">&times;</button></div>
<div class="modal-body">
<div class="form-group"><label>Code</label><input name="code" class="form-control" placeholder="MAIN" required></div>
<div class="form-group"><label>Name</label><input name="name" class="form-control" required></div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
