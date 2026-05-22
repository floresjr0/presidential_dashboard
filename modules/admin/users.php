<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['admin']);
require_once __DIR__ . '/../../includes/nav.php';
$users = getDB()->query("SELECT u.*, c.name as campus_name FROM users u LEFT JOIN campuses c ON u.campus_id = c.id ORDER BY u.role, u.full_name");
$campuses = getCampuses();
$institutes = getInstitutes();
$departments = getDepartments();
$pageTitle = 'User Management';
$sidebarNav = adminNav();
$user = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'userModal\')">+ Add User</button>';
require __DIR__ . '/../../includes/layout.php';
?>
<div class="card"><div class="card-body table-wrap">
<table><thead><tr><th>Username</th><th>Name</th><th>Role</th><th>Campus</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php while ($u = $users->fetch_assoc()): ?>
<tr>
    <td><?= e($u['username']) ?></td><td><?= e($u['full_name']) ?></td>
    <td><span class="badge badge-primary"><?= e(roleLabel($u['role'])) ?></span></td>
    <td><?= e($u['campus_name'] ?? '—') ?></td>
    <td><span class="badge badge-<?= $u['status']==='active'?'success':'danger' ?>"><?= e($u['status']) ?></span></td>
    <td class="actions-cell">
        <form method="POST" action="<?= APP_URL ?>/actions/handler.php" style="display:inline;" onsubmit="return confirm('Delete user?')">
            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
            <input type="hidden" name="action" value="delete_record">
            <input type="hidden" name="table" value="users">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">
            <input type="hidden" name="redirect" value="/modules/admin/users.php">
            <button type="submit" class="btn btn-sm btn-danger" <?= $u['id']==$user['id']?'disabled':'' ?>>Delete</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</tbody></table></div></div>

<div class="modal-overlay" id="userModal">
<div class="modal">
<div class="modal-header"><h3>Add User</h3><button onclick="closeModal('userModal')">&times;</button></div>
<form method="POST" action="<?= APP_URL ?>/actions/handler.php">
<input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
<input type="hidden" name="action" value="create_user">
<div class="modal-body">
<div class="form-row">
<div class="form-group"><label>Username</label><input name="username" class="form-control" required></div>
<div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required></div>
</div>
<div class="form-group"><label>Full Name</label><input name="full_name" class="form-control" required></div>
<div class="form-group"><label>Email</label><input name="email" type="email" class="form-control"></div>
<div class="form-group"><label>Role</label>
<select name="role" class="form-control" required>
<?php foreach (['admin','president','registrar','finance','research','hr','department_head','campus_admin','guidance','mis'] as $r): ?>
<option value="<?= $r ?>"><?= roleLabel($r) ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row">
<div class="form-group"><label>Campus</label><select name="campus_id" class="form-control"><option value="">—</option><?php foreach($campuses as $c):?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Institute</label><select name="institute_id" class="form-control"><option value="">—</option><?php foreach($institutes as $i):?><option value="<?= $i['id'] ?>"><?= e($i['name']) ?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Department</label><select name="department_id" class="form-control"><option value="">—</option><?php foreach($departments as $d):?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?></select></div>
</div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-outline" onclick="closeModal('userModal')">Cancel</button><button type="submit" class="btn btn-primary">Create User</button></div>
</form></div></div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
