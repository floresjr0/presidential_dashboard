<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT * FROM announcements ORDER BY created_at DESC");
$pageTitle = 'Announcements';
$sidebarNav = adminNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'annModal\')">+ Post</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Title</th><th>Type</th><th>Target</th><th>Pinned</th><th>Date</th></tr></thead><tbody>
<?php while ($a = $rows->fetch_assoc()): ?>
<tr><td><?= e($a['title']) ?></td><td><?= e($a['type']) ?></td><td><?= e($a['target_role']) ?></td><td><?= $a['is_pinned']?'Yes':'No' ?></td><td><?= e($a['created_at']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="annModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_announcement">
<div class="modal-header"><h3>Post Announcement</h3><button type="button" onclick="closeModal('annModal')">&times;</button></div>
<div class="modal-body">
<div class="form-group"><label>Title</label><input name="title" class="form-control" required></div>
<div class="form-group"><label>Content</label><textarea name="content" class="form-control" required></textarea></div>
<div class="form-row">
<div class="form-group"><label>Type</label><select name="type" class="form-control"><option value="announcement">Announcement</option><option value="memorandum">Memorandum</option><option value="reminder">Reminder</option><option value="deadline">Deadline</option></select></div>
<div class="form-group"><label>Target Role</label><select name="target_role" class="form-control"><option value="all">All</option><?php foreach(['registrar','finance','research'] as $r):?><option value="<?= $r ?>"><?= roleLabel($r) ?></option><?php endforeach; ?></select></div>
</div>
<label><input type="checkbox" name="is_pinned" value="1"> Pin to top</label>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Post</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
