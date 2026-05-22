<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['finance','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT f.*, c.name as campus FROM finance_records f LEFT JOIN campuses c ON f.campus_id=c.id ORDER BY f.record_date DESC");
$campuses = getCampuses();
$years = getAcademicYears();
$pageTitle = 'Financial Records';
$sidebarNav = financeNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'finModal\')">+ Add Record</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Date</th><th>Type</th><th>Title</th><th>Amount</th><th>Category</th><th>Campus</th></tr></thead><tbody>
<?php while ($r = $rows->fetch_assoc()): ?>
<tr><td><?= e($r['record_date']) ?></td><td><span class="badge badge-<?= $r['record_type']==='revenue'?'success':($r['record_type']==='expense'?'danger':'info') ?>"><?= e($r['record_type']) ?></span></td>
<td><?= e($r['title']) ?></td><td>₱<?= number_format($r['amount'],2) ?></td><td><?= e($r['category']) ?></td><td><?= e($r['campus']??'All') ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<div class="modal-overlay" id="finModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_finance">
<div class="modal-header"><h3>Add Financial Record</h3><button type="button" onclick="closeModal('finModal')">&times;</button></div>
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Type</label><select name="record_type" class="form-control"><option value="revenue">Revenue</option><option value="expense">Expense</option><option value="budget_allocation">Budget Allocation</option></select></div>
<div class="form-group"><label>Date</label><input type="date" name="record_date" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
</div>
<div class="form-group"><label>Title</label><input name="title" class="form-control" required></div>
<div class="form-row">
<div class="form-group"><label>Amount (₱)</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
<div class="form-group"><label>Category</label><input name="category" class="form-control" placeholder="Tuition, Payroll, etc."></div>
</div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control"><option value="">University-wide</option><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Academic Year</label><select name="academic_year_id" class="form-control"><?php foreach($years as $y):?><option value="<?= $y['id'] ?>"><?= e($y['year_label']) ?></option><?php endforeach; ?></select></div>
</div>
<div class="form-group"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
