<?php
function navIcon(string $name): string {
    $s = 'xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"';
    $icons = [
        'dashboard' => '<svg '.$s.'><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>',
        'users'     => '<svg '.$s.'><circle cx="9" cy="7" r="4"/><path d="M2 21v-1a7 7 0 0 1 14 0v1"/><path d="M19 11a3 3 0 1 0 0-6"/><path d="M22 21v-1a5 5 0 0 0-4-4.9"/></svg>',
        'announce'  => '<svg '.$s.'><path d="M22 4.5 12 12 2 4.5"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>',
        'exec'      => '<svg '.$s.'><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 12h8M8 8h5M8 16h3"/></svg>',
        'logs'      => '<svg '.$s.'><path d="M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>',
        'finance'   => '<svg '.$s.'><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'research'  => '<svg '.$s.'><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        'upload'    => '<svg '.$s.'><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>',
        'enroll'    => '<svg '.$s.'><path d="M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
        'students'  => '<svg '.$s.'><circle cx="12" cy="7" r="4"/><path d="M5 21v-1a7 7 0 0 1 14 0v1"/></svg>',
        'records'   => '<svg '.$s.'><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
        'employees' => '<svg '.$s.'><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>',
        'courses'   => '<svg '.$s.'><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
        'campuses'  => '<svg '.$s.'><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
        'pop'       => '<svg '.$s.'><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'stats'     => '<svg '.$s.'><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
    ];
    return $icons[$name] ?? $icons['dashboard'];
}

function adminNav(): array {
    return [
        ['href' => '/modules/admin/index.php',        'label' => 'Dashboard',      'icon' => navIcon('dashboard')],
        ['href' => '/modules/admin/users.php',         'label' => 'Users',          'icon' => navIcon('users')],
        ['href' => '/modules/admin/announcements.php', 'label' => 'Announcements',  'icon' => navIcon('announce')],
        ['href' => '/modules/president/index.php',     'label' => 'Executive View', 'icon' => navIcon('exec')],
        ['href' => '/modules/admin/logs.php',          'label' => 'Audit Logs',     'icon' => navIcon('logs')],
    ];
}
function presidentNav(): array {
    return [
        ['href' => '/modules/president/index.php',        'label' => 'Executive Dashboard', 'icon' => navIcon('dashboard')],
        ['href' => '/modules/president/population.php',   'label' => 'Population',          'icon' => navIcon('pop')],
        ['href' => '/modules/president/finance.php',      'label' => 'Finance Overview',    'icon' => navIcon('finance')],
        ['href' => '/modules/research/library.php',       'label' => 'Research Library',    'icon' => navIcon('research')],
        ['href' => '/modules/president/announcements.php','label' => 'Announcements',       'icon' => navIcon('announce')],
    ];
}
function registrarNav(): array {
    return [
        ['href' => '/modules/registrar/index.php',      'label' => 'Dashboard',        'icon' => navIcon('dashboard')],
        ['href' => '/modules/registrar/enrollment.php', 'label' => 'Enrollment Stats', 'icon' => navIcon('enroll')],
        ['href' => '/modules/registrar/students.php',   'label' => 'Students',         'icon' => navIcon('students')],
    ];
}
function financeNav(): array {
    return [
        ['href' => '/modules/finance/index.php',  'label' => 'Dashboard',        'icon' => navIcon('dashboard')],
        ['href' => '/modules/finance/records.php','label' => 'Financial Records', 'icon' => navIcon('records')],
    ];
}
function researchNav(): array {
    return [
        ['href' => '/modules/research/index.php',    'label' => 'Dashboard',        'icon' => navIcon('dashboard')],
        ['href' => '/modules/research/documents.php','label' => 'Upload & Manage',  'icon' => navIcon('upload')],
        ['href' => '/modules/research/library.php',  'label' => 'Research Library', 'icon' => navIcon('research')],
    ];
}
function hrNav(): array {
    return [
        ['href' => '/modules/hr/index.php',     'label' => 'Dashboard',     'icon' => navIcon('dashboard')],
        ['href' => '/modules/hr/employees.php', 'label' => 'All Employees', 'icon' => navIcon('employees')],
    ];
}
function departmentNav(): array {
    return [
        ['href' => '/modules/department/index.php',     'label' => 'Dashboard',       'icon' => navIcon('dashboard')],
        ['href' => '/modules/department/employees.php', 'label' => 'Department Staff', 'icon' => navIcon('employees')],
    ];
}
function campusNav(): array {
    return [
        ['href' => '/modules/campus/index.php',     'label' => 'Dashboard',        'icon' => navIcon('dashboard')],
        ['href' => '/modules/campus/employees.php', 'label' => 'Campus Employees', 'icon' => navIcon('employees')],
        ['href' => '/modules/campus/courses.php',   'label' => 'Courses',          'icon' => navIcon('courses')],
    ];
}
function guidanceNav(): array {
    return [
        ['href' => '/modules/guidance/index.php',   'label' => 'Dashboard',         'icon' => navIcon('dashboard')],
        ['href' => '/modules/guidance/students.php','label' => 'Student Statistics', 'icon' => navIcon('stats')],
    ];
}
function misNav(): array {
    return [
        ['href' => '/modules/mis/index.php',    'label' => 'Dashboard',   'icon' => navIcon('dashboard')],
        ['href' => '/modules/mis/campuses.php', 'label' => 'Campuses',    'icon' => navIcon('campuses')],
        ['href' => '/modules/admin/logs.php',   'label' => 'System Logs', 'icon' => navIcon('logs')],
    ];
}
function loginPanelFeatures(): array {
    return [
        ['icon' => navIcon('pop'),     'label' => 'Role-based access per department'],
        ['icon' => navIcon('records'), 'label' => 'Multi-campus population monitoring'],
        ['icon' => navIcon('finance'), 'label' => 'Finance and research at a glance'],
    ];
}