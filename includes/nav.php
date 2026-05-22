<?php
function adminNav(): array {
    return [
        ['href' => '/modules/admin/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/admin/users.php', 'label' => 'Users', 'icon' => ''],
        ['href' => '/modules/admin/announcements.php', 'label' => 'Announcements', 'icon' => ''],
        ['href' => '/modules/president/index.php', 'label' => 'Executive View', 'icon' => ''],
        ['href' => '/modules/admin/logs.php', 'label' => 'Audit Logs', 'icon' => ''],
    ];
}
function presidentNav(): array {
    return [
        ['href' => '/modules/president/index.php', 'label' => 'Executive Dashboard', 'icon' => ''],
        ['href' => '/modules/president/population.php', 'label' => 'Population', 'icon' => ''],
        ['href' => '/modules/president/finance.php', 'label' => 'Finance Overview', 'icon' => ''],
        ['href' => '/modules/research/library.php', 'label' => 'Research Library', 'icon' => ''],
        ['href' => '/modules/president/announcements.php', 'label' => 'Announcements', 'icon' => ''],
    ];
}
function registrarNav(): array {
    return [
        ['href' => '/modules/registrar/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/registrar/enrollment.php', 'label' => 'Enrollment Stats', 'icon' => ''],
        ['href' => '/modules/registrar/students.php', 'label' => 'Students', 'icon' => ''],
    ];
}
function financeNav(): array {
    return [
        ['href' => '/modules/finance/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/finance/records.php', 'label' => 'Financial Records', 'icon' => ''],
    ];
}
function researchNav(): array {
    return [
        ['href' => '/modules/research/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/research/documents.php', 'label' => 'Upload & Manage', 'icon' => ''],
        ['href' => '/modules/research/library.php', 'label' => 'Research Library', 'icon' => ''],
    ];
}
function hrNav(): array {
    return [
        ['href' => '/modules/hr/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/hr/employees.php', 'label' => 'All Employees', 'icon' => ''],
    ];
}
function departmentNav(): array {
    return [
        ['href' => '/modules/department/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/department/employees.php', 'label' => 'Department Staff', 'icon' => ''],
    ];
}
function campusNav(): array {
    return [
        ['href' => '/modules/campus/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/campus/employees.php', 'label' => 'Campus Employees', 'icon' => ''],
        ['href' => '/modules/campus/courses.php', 'label' => 'Courses', 'icon' => ''],
    ];
}
function guidanceNav(): array {
    return [
        ['href' => '/modules/guidance/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/guidance/students.php', 'label' => 'Student Statistics', 'icon' => ''],
    ];
}
function misNav(): array {
    return [
        ['href' => '/modules/mis/index.php', 'label' => 'Dashboard', 'icon' => '⌂'],
        ['href' => '/modules/mis/campuses.php', 'label' => 'Campuses', 'icon' => ''],
        ['href' => '/modules/admin/logs.php', 'label' => 'System Logs', 'icon' => ''],
    ];
}
