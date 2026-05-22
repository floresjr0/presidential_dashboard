<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['research','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$db = getDB();
$ongoing = $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='ongoing'")->fetch_assoc()['c'];
$completed = $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='completed'")->fetch_assoc()['c'];
$published = $db->query("SELECT COUNT(*) c FROM research_documents WHERE status='published'")->fetch_assoc()['c'];
$pageTitle = 'Research Dashboard';
$sidebarNav = researchNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card warning"><div class="label">Ongoing</div><div class="value"><?= $ongoing ?></div></div>
    <div class="stat-card success"><div class="label">Completed</div><div class="value"><?= $completed ?></div></div>
    <div class="stat-card"><div class="label">Published</div><div class="value"><?= $published ?></div></div>
</div>
<a href="<?= APP_URL ?>/modules/research/documents.php" class="btn btn-primary">Upload Research</a>
<a href="<?= APP_URL ?>/modules/research/library.php" class="btn btn-outline">View Library</a>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
