<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['admin']);
require_once __DIR__ . '/../../includes/nav.php';
$rows = getDB()->query("SELECT * FROM announcements ORDER BY is_pinned DESC, created_at DESC");
$pageTitle  = 'Announcements';
$sidebarNav = adminNav();
$user       = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'annModal\')">+ Post Announcement</button>';
require __DIR__ . '/../../includes/layout.php';
?>

<div class="card">
    <div class="card-header">
        <span>All Announcements</span>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Target</th>
                        <th>Pinned</th>
                        <th>Date Posted</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($a = $rows->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="ann-title">
                            <?php if ($a['is_pinned']): ?>
                            <span class="pin-icon" title="Pinned">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z"/></svg>
                            </span>
                            <?php endif; ?>
                            <?= e($a['title']) ?>
                        </div>
                    </td>
                    <td><span class="badge badge-type badge-<?= e($a['type']) ?>"><?= e(ucfirst($a['type'])) ?></span></td>
                    <td><?= $a['target_role'] === 'all' ? 'Everyone' : e(roleLabel($a['target_role'])) ?></td>
                    <td>
                        <?php if ($a['is_pinned']): ?>
                        <span class="badge badge-pinned">Pinned</span>
                        <?php else: ?>
                        <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="date-cell"><?= date('M j, Y', strtotime($a['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Post Announcement Modal -->
<div class="modal-overlay" id="annModal">
    <div class="modal">
        <div class="modal-header">
            <span>Post Announcement</span>
            <button type="button" onclick="closeModal('annModal')">&times;</button>
        </div>
        <form method="POST" action="<?= APP_URL ?>/actions/handler.php">
            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
            <input type="hidden" name="action" value="save_announcement">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" class="form-control" required placeholder="Announcement title">
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="content" class="form-control" required placeholder="Write your announcement here..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="announcement">Announcement</option>
                            <option value="memorandum">Memorandum</option>
                            <option value="reminder">Reminder</option>
                            <option value="deadline">Deadline</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Target Role</label>
                        <select name="target_role" class="form-control">
                            <option value="all">Everyone</option>
                            <?php foreach (['registrar','finance','research','hr','department_head','campus_admin','guidance','mis'] as $r): ?>
                            <option value="<?= $r ?>"><?= roleLabel($r) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <label class="pin-checkbox">
                    <input type="checkbox" name="is_pinned" value="1">
                    <span>Pin to top</span>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('annModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>