<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['department_head','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$user = currentUser();
$deptId = $user['department_id'];
$stmt = getDB()->prepare("SELECT e.*, c.name as campus FROM employees e JOIN campuses c ON e.campus_id=c.id WHERE e.department_id = ? ORDER BY e.full_name");
$stmt->bind_param('i', $deptId);
$stmt->execute();
$rows = $stmt->get_result();
$campuses = getCampuses();
$institutes = getInstitutes($user['campus_id']);
$departments = getDepartments($user['institute_id']);
$pageTitle = 'Department Employees';
$sidebarNav = departmentNav();
$redirect = '/modules/department/employees.php';
$prefillCampus = $user['campus_id'];
$prefillInstitute = $user['institute_id'];
$prefillDepartment = $user['department_id'];
$lockDepartment = true;
$lockInstitute = true;
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'empModal\')">+ Add Staff</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Position</th><th>Gender</th><th>Status</th></tr></thead><tbody>
<?php while ($e = $rows->fetch_assoc()): ?>
<tr><td><?= e($e['employee_id']) ?></td><td><?= e($e['full_name']) ?></td><td><?= e($e['employee_type']) ?></td><td><?= e($e['position']) ?></td><td><?= e($e['gender']) ?></td><td><?= e($e['status']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php require __DIR__ . '/../../includes/employee_form.php'; ?>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
