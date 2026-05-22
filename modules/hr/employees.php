<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['hr','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT e.*, c.name as campus, d.name as department FROM employees e JOIN campuses c ON e.campus_id=c.id LEFT JOIN departments d ON e.department_id=d.id ORDER BY e.full_name");
$campuses = getCampuses(); $institutes = getInstitutes(); $departments = getDepartments();
$pageTitle = 'Employee Management';
$sidebarNav = hrNav();
$user = currentUser();
$redirect = '/modules/hr/employees.php';
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'empModal\')">+ Add Employee</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>ID</th><th>Name</th><th>Gender</th><th>Type</th><th>Campus</th><th>Department</th><th>Position</th><th>Status</th></tr></thead><tbody>
<?php while ($e = $rows->fetch_assoc()): ?>
<tr><td><?= e($e['employee_id']) ?></td><td><?= e($e['full_name']) ?></td><td><?= e($e['gender']) ?></td><td><?= e($e['employee_type']) ?></td>
<td><?= e($e['campus']) ?></td><td><?= e($e['department']??'—') ?></td><td><?= e($e['position']) ?></td><td><span class="badge badge-success"><?= e($e['status']) ?></span></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php require __DIR__ . '/../../includes/employee_form.php'; ?>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
