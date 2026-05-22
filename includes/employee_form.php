<?php
/** Expects: $campuses, $institutes, $departments, $redirect, optional $prefill campus/inst/dept */
?>
<div class="modal-overlay" id="empModal"><div class="modal">
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
<input type="hidden" name="action" value="save_employee">
<input type="hidden" name="redirect" value="<?= e($redirect) ?>">
<div class="modal-header"><h3>Add Employee</h3><button type="button" onclick="closeModal('empModal')">&times;</button></div>
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Employee ID</label><input name="employee_id" class="form-control" required></div>
<div class="form-group"><label>Full Name</label><input name="full_name" class="form-control" required></div>
</div>
<div class="form-row">
<div class="form-group"><label>Gender</label><select name="gender" class="form-control"><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div>
<div class="form-group"><label>Type</label><select name="employee_type" class="form-control"><option value="instructor">Instructor</option><option value="non_teaching">Non-Teaching</option><option value="administrative">Administrative</option></select></div>
<div class="form-group"><label>Position</label><input name="position" class="form-control"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control" required><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>" <?= ($prefillCampus??null)==$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<?php if (empty($lockInstitute)): ?>
<div class="form-group"><label>Institute</label><select name="institute_id" class="form-control"><option value="">—</option><?php foreach($institutes as $i):?><option value="<?= $i['id'] ?>" <?= ($prefillInstitute??null)==$i['id']?'selected':'' ?>><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
<?php else: ?><input type="hidden" name="institute_id" value="<?= $prefillInstitute ?>"><?php endif; ?>
<?php if (empty($lockDepartment)): ?>
<div class="form-group"><label>Department</label><select name="department_id" class="form-control"><option value="">—</option><?php foreach($departments as $d):?><option value="<?= $d['id'] ?>" <?= ($prefillDepartment??null)==$d['id']?'selected':'' ?>><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
<?php else: ?><input type="hidden" name="department_id" value="<?= $prefillDepartment ?>"><?php endif; ?>
</div>
<div class="form-row">
<div class="form-group"><label>Email</label><input name="email" type="email" class="form-control"></div>
<div class="form-group"><label>Phone</label><input name="phone" class="form-control"></div>
<div class="form-group"><label>Hire Date</label><input type="date" name="hire_date" class="form-control"></div>
</div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Save Employee</button></div>
</form></div></div>
