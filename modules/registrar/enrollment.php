<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['registrar','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$db = getDB();
$stats = $db->query("SELECT es.*, ay.year_label, s.name as semester, c.name as campus, i.name as institute FROM enrollment_stats es JOIN academic_years ay ON es.academic_year_id=ay.id JOIN semesters s ON es.semester_id=s.id JOIN campuses c ON es.campus_id=c.id LEFT JOIN institutes i ON es.institute_id=i.id ORDER BY es.created_at DESC");
$campuses = getCampuses();
$institutes = getInstitutes();
$years = getAcademicYears();
$semesters = getSemesters();
$courses = getCourses();
$pageTitle = 'Enrollment Statistics';
$sidebarNav = registrarNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'enrollModal\')">+ Add Stats</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>AY</th><th>Semester</th><th>Campus</th><th>Institute</th><th>Enrolled</th><th>Graduating</th><th>BASCAT</th><th>Drops</th><th>M/F</th></tr></thead><tbody>
<?php while ($r = $stats->fetch_assoc()): ?>
<tr><td><?= e($r['year_label']) ?></td><td><?= e($r['semester']) ?></td><td><?= e($r['campus']) ?></td><td><?= e($r['institute']??'All') ?></td>
<td><?= $r['enrolled_count'] ?></td><td><?= $r['graduating_count'] ?></td><td><?= $r['bascat_count'] ?></td><td><?= $r['drop_count'] ?></td>
<td><?= $r['male_count'] ?>/<?= $r['female_count'] ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>

<div class="modal-overlay" id="enrollModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>"><input type="hidden" name="action" value="save_enrollment_stats">
<div class="modal-header"><h3>Enrollment Statistics per Institute</h3><button type="button" onclick="closeModal('enrollModal')">&times;</button></div>
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Academic Year</label><select name="academic_year_id" class="form-control" required><?php foreach($years as $y):?><option value="<?= $y['id'] ?>" <?= $y['is_current']?'selected':'' ?>><?= e($y['year_label']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Semester</label><select name="semester_id" class="form-control" required><?php foreach($semesters as $s):?><option value="<?= $s['id'] ?>"><?= e($s['name']) ?></option><?php endforeach; ?></select></div>
</div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control" required><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Institute</label><select name="institute_id" class="form-control"><option value="">All / Campus-wide</option><?php foreach($institutes as $i):?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Course (optional)</label><select name="course_id" class="form-control"><option value="">—</option><?php foreach($courses as $co):?><option value="<?= $co['id'] ?>"><?= e($co['name']) ?></option><?php endforeach; ?></select></div>
</div>
<div class="form-row">
<div class="form-group"><label>Enrolled</label><input type="number" name="enrolled_count" class="form-control" required min="0"></div>
<div class="form-group"><label>Graduating</label><input type="number" name="graduating_count" class="form-control" min="0" value="0"></div>
<div class="form-group"><label>BASCAT Takers</label><input type="number" name="bascat_count" class="form-control" min="0" value="0"></div>
<div class="form-group"><label>Drops</label><input type="number" name="drop_count" class="form-control" min="0" value="0"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Male Count</label><input type="number" name="male_count" class="form-control" min="0" value="0"></div>
<div class="form-group"><label>Female Count</label><input type="number" name="female_count" class="form-control" min="0" value="0"></div>
</div>
<div class="form-group"><label>Notes</label><textarea name="notes" class="form-control"></textarea></div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
