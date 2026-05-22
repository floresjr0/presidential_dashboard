<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['department_head','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$user = currentUser();
$db = getDB();
$deptId = $user['department_id'];
$empCount = $db->query("SELECT COUNT(*) c FROM employees WHERE department_id=$deptId AND status='active'")->fetch_assoc()['c'] ?? 0;
$pageTitle = 'Department Dashboard';
$sidebarNav = departmentNav();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stat-card"><div class="label">Department Employees</div><div class="value"><?= $empCount ?></div></div>
<p class="mt-2">Manage faculty and staff credentials under your department.</p>
<a href="<?= APP_URL ?>/modules/department/employees.php" class="btn btn-primary mt-2">Manage Department Staff</a>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
