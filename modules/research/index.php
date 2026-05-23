<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['research','admin']);
require_once __DIR__ . '/../../includes/nav.php';

$db = getDB();
$stats = [
    'research_ongoing'   => $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='ongoing'")->fetch_assoc()['c'],
    'research_completed' => $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='completed'")->fetch_assoc()['c'],
    'research_published' => $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='published'")->fetch_assoc()['c'],
];

$statsContext = 'research';
$pageTitle    = 'Research Dashboard';
$sidebarNav   = researchNav();
$user         = currentUser();
require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>

<div class="card">
    <div class="card-header">Quick Actions</div>
    <div class="card-body" style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/modules/research/documents.php" class="btn btn-primary">+ Upload Research</a>
        <a href="<?= APP_URL ?>/modules/research/library.php"   class="btn btn-outline">View Library</a>
    </div>
</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>