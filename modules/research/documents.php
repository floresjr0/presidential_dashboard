<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['research','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT r.*, c.name as campus, d.name as department FROM research_documents r LEFT JOIN campuses c ON r.campus_id=c.id LEFT JOIN departments d ON r.department_id=d.id ORDER BY r.updated_at DESC");
$campuses = getCampuses(); $departments = getDepartments(); $years = getAcademicYears();
$pageTitle = 'Research Documents';
$sidebarNav = researchNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'resModal\')">+ Upload</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Title</th><th>Authors</th><th>Status</th><th>Campus</th><th>File</th><th>Updated</th></tr></thead><tbody>
<?php while ($r = $rows->fetch_assoc()): ?>
<tr><td><?= e($r['title']) ?></td><td><?= e($r['authors']) ?></td><td><span class="badge badge-info"><?= e($r['status']) ?></span></td><td><?= e($r['campus']??'—') ?></td>
<td><?= $r['file_path'] ? '<a href="'.APP_URL.'/uploads/research/'.e($r['file_path']).'" target="_blank">Download</a>' : '—' ?></td><td><?= e($r['updated_at']) ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="resModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_research">
<div class="modal-header"><h3>Upload Research</h3><button type="button" onclick="closeModal('resModal')">&times;</button></div>
<div class="modal-body">
<div class="form-group"><label>Title</label><input name="title" class="form-control" required></div>
<div class="form-group"><label>Authors</label><input name="authors" class="form-control"></div>
<div class="form-group"><label>Abstract</label><textarea name="abstract" class="form-control"></textarea></div>
<div class="form-row">
<div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="ongoing">Ongoing</option><option value="completed">Completed</option><option value="published">Published</option><option value="archived">Archived</option></select></div>
<div class="form-group"><label>Document (PDF/DOC)</label><input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control"><option value="">—</option><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Department</label><select name="department_id" class="form-control"><option value="">—</option><?php foreach($departments as $d):?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
</div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Upload</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
