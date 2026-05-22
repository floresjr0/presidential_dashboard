<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['registrar','admin','guidance']);
require_once __DIR__ . '/../../includes/nav.php';
$sidebarNav = ($_SESSION['role']??'')==='guidance' ? guidanceNav() : registrarNav();
$rows = getDB()->query("SELECT s.*, c.name as campus, co.name as course FROM students s JOIN campuses c ON s.campus_id=c.id LEFT JOIN courses co ON s.course_id=co.id ORDER BY s.full_name");
$campuses = getCampuses(); $institutes = getInstitutes(); $departments = getDepartments(); $courses = getCourses();
$pageTitle = 'Student Records';
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'stuModal\')">+ Add Student</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>ID</th><th>Name</th><th>Gender</th><th>Campus</th><th>Course</th><th>Status</th><th>Year</th></tr></thead><tbody>
<?php while ($s = $rows->fetch_assoc()): ?>
<tr><td><?= e($s['student_id']) ?></td><td><?= e($s['full_name']) ?></td><td><?= e($s['gender']) ?></td><td><?= e($s['campus']) ?></td><td><?= e($s['course']??'—') ?></td>
<td><span class="badge badge-info"><?= e($s['status']) ?></span></td><td><?= $s['year_level'] ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="stuModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_student">
<div class="modal-header"><h3>Add Student</h3><button type="button" onclick="closeModal('stuModal')">&times;</button></div>
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Student ID</label><input name="student_id" class="form-control" required></div>
<div class="form-group"><label>Full Name</label><input name="full_name" class="form-control" required></div>
</div>
<div class="form-row">
<div class="form-group"><label>Gender</label><select name="gender" class="form-control"><option value="male">Male</option><option value="female">Female</option></select></div>
<div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="enrolled">Enrolled</option><option value="graduating">Graduating</option><option value="bascat">BASCAT</option><option value="dropped">Dropped</option><option value="graduated">Graduated</option></select></div>
<div class="form-group"><label>Year Level</label><input type="number" name="year_level" class="form-control" value="1" min="1"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control" required><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Institute</label><select name="institute_id" class="form-control"><?php foreach($institutes as $i):?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Department</label><select name="department_id" class="form-control"><?php foreach($departments as $d):?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Course</label><select name="course_id" class="form-control"><?php foreach($courses as $co):?><option value="<?= $co['id'] ?>"><?= e($co['name']) ?></option><?php endforeach; ?></select></div>
</div>
<div class="form-group"><label>Email</label><input name="email" type="email" class="form-control"></div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
