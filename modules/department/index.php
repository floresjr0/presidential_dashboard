<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['department_head','admin']);
require_once __DIR__ . '/../../includes/nav.php';

$user   = currentUser();
$db     = getDB();
$deptId = $user['department_id'];

$empCount = $db->query("SELECT COUNT(*) c FROM employees WHERE department_id=$deptId AND status='active'")->fetch_assoc()['c'] ?? 0;

$pageTitle  = 'Department Dashboard';
$sidebarNav = departmentNav();

require __DIR__ . '/../../includes/layout.php';
?>

<div style="max-width: 320px; display: flex; flex-direction: column; gap: 12px;">

    <div class="stat-card">
        <span class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
        </span>
        <div class="label">Department Employees</div>
        <div class="value"><?= $empCount ?></div>
        <div class="sub">Active staff</div>
    </div>

    <a href="<?= APP_URL ?>/modules/department/employees.php" class="btn btn-primary btn-block">
        Manage Department Staff
    </a>

</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>