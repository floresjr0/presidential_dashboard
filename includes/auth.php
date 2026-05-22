<?php

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'full_name' => $_SESSION['full_name'],
        'role' => $_SESSION['role'],
        'campus_id' => $_SESSION['campus_id'] ?? null,
        'institute_id' => $_SESSION['institute_id'] ?? null,
        'department_id' => $_SESSION['department_id'] ?? null,
    ];
}

function requireLogin(): void {
    if (!isLoggedIn()) redirect('/index.php');
}

function requireRole(array $roles): void {
    requireLogin();
    if (!in_array($_SESSION['role'], $roles, true)) {
        flash('error', 'Access denied.');
        redirect('/dashboard.php');
    }
}

function canEdit(): bool {
    return in_array($_SESSION['role'] ?? '', ['admin','registrar','finance','research','hr','department_head','campus_admin','guidance','mis'], true);
}

function isViewOnly(): bool {
    return ($_SESSION['role'] ?? '') === 'president';
}

function roleDashboardPath(string $role): string {
    $paths = [
        'admin' => '/modules/admin/index.php',
        'president' => '/modules/president/index.php',
        'registrar' => '/modules/registrar/index.php',
        'finance' => '/modules/finance/index.php',
        'research' => '/modules/research/index.php',
        'hr' => '/modules/hr/index.php',
        'department_head' => '/modules/department/index.php',
        'campus_admin' => '/modules/campus/index.php',
        'guidance' => '/modules/guidance/index.php',
        'mis' => '/modules/mis/index.php',
    ];
    return $paths[$role] ?? '/dashboard.php';
}

function loginUser(array $user): void {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['campus_id'] = $user['campus_id'];
    $_SESSION['institute_id'] = $user['institute_id'];
    $_SESSION['department_id'] = $user['department_id'];
    $db = getDB();
    $stmt = $db->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
    $stmt->bind_param('i', $user['id']);
    $stmt->execute();
    auditLog('login', 'auth', $user['id'], 'User logged in');
}

function logoutUser(): void {
    if (isLoggedIn()) auditLog('logout', 'auth', $_SESSION['user_id'], 'User logged out');
    session_destroy();
}
