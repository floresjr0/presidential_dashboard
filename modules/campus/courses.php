<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['campus_admin','admin','mis']);
require_once __DIR__ . '/../../includes/nav.php';
$user = currentUser();
$cid = $user['campus_id'] ?? null;
if ($user['role'] === 'admin' || $user['role'] === 'mis') $cid = isset($_GET['campus']) ? (int)$_GET['campus'] : null;
$sql = "SELECT co.*, ca.name as campus, i.name as institute FROM courses co JOIN campuses ca ON co.campus_id=ca.id LEFT JOIN institutes i ON co.institute_id=i.id";
if ($cid) $sql .= " WHERE co.campus_id=$cid";
$sql .= " ORDER BY ca.name, co.name";
$rows = getDB()->query($sql);
$campuses = getCampuses();
$institutes = $cid ? getInstitutes($cid) : getInstitutes();
$pageTitle = 'Campus Courses';
$sidebarNav = ($_SESSION['role']??'')==='mis' ? misNav() : campusNav();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'courseModal\')">+ Add Course</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Code</th><th>Name</th><th>Campus</th><th>Institute</th><th>Level</th></tr></thead><tbody>
<?php while ($c = $rows->fetch_assoc()): ?>
<tr><td><?= e($c['code']) ?></td><td><?= e($c['name']) ?></td><td><?= e($c['campus']) ?></td><td><?= e($c['institute']??'—') ?></td><td><?= e($c['level']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="courseModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_course">
<div class="modal-header"><h3>Add Course</h3><button type="button" onclick="closeModal('courseModal')">&times;</button></div>
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control" required><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>" <?= $cid==$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Institute</label><select name="institute_id" class="form-control"><option value="">—</option><?php foreach($institutes as $i):?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
</div>
<div class="form-row">
<div class="form-group"><label>Code</label><input name="code" class="form-control" required></div>
<div class="form-group"><label>Name</label><input name="name" class="form-control" required></div>
<div class="form-group"><label>Level</label><select name="level" class="form-control"><option value="undergraduate">Undergraduate</option><option value="graduate">Graduate</option><option value="doctoral">Doctoral</option></select></div>
</div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
