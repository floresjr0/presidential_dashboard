<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['campus_admin','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$user = currentUser();
$cid = (int)$user['campus_id'];
$stmt = getDB()->prepare("SELECT e.*, d.name as department FROM employees e LEFT JOIN departments d ON e.department_id=d.id WHERE e.campus_id=? ORDER BY e.full_name");
$stmt->bind_param('i', $cid);
$stmt->execute();
$rows = $stmt->get_result();
$campuses = getCampuses();
$institutes = getInstitutes($cid);
$departments = getDepartments();
$pageTitle = 'Campus Employees';
$sidebarNav = campusNav();
$redirect = '/modules/campus/employees.php';
$prefillCampus = $cid;
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'empModal\')">+ Add Employee</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Department</th><th>Position</th></tr></thead><tbody>
<?php while ($e = $rows->fetch_assoc()): ?>
<tr><td><?= e($e['employee_id']) ?></td><td><?= e($e['full_name']) ?></td><td><?= e($e['employee_type']) ?></td><td><?= e($e['department']??'—') ?></td><td><?= e($e['position']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php require __DIR__ . '/../../includes/employee_form.php'; ?>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
