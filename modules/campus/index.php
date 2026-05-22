<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['campus_admin','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$user = currentUser();
$stats = getDashboardStats($user['campus_id']);
$campus = getDB()->query("SELECT * FROM campuses WHERE id=" . (int)$user['campus_id'])->fetch_assoc();
$pageTitle = 'Campus Dashboard — ' . ($campus['name'] ?? '');
$sidebarNav = campusNav();
require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
