<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['president','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT a.*, u.full_name as author FROM announcements a LEFT JOIN users u ON a.posted_by = u.id ORDER BY a.is_pinned DESC, a.created_at DESC");
$pageTitle = 'Announcements';
$sidebarNav = presidentNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body">
<?php while ($a = $rows->fetch_assoc()): ?>
<div style="padding:16px 0;border-bottom:1px solid var(--border);">
    <h3><?= e($a['title']) ?> <span class="badge badge-info"><?= e($a['type']) ?></span></h3>
    <p class="text-muted" style="font-size:.85rem;"><?= e($a['author']) ?> — <?= e($a['created_at']) ?></p>
    <p><?= nl2br(e($a['content'])) ?></p>
</div>
<?php endwhile; ?>
</div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
