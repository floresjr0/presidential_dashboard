<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['research','admin']);
require_once __DIR__ . '/../../includes/nav.php';

$db          = getDB();
$rows        = $db->query("SELECT r.*, c.name AS campus, d.name AS department
                            FROM research_documents r
                            LEFT JOIN campuses    c ON r.campus_id    = c.id
                            LEFT JOIN departments d ON r.department_id = d.id
                            ORDER BY r.updated_at DESC");
$campuses    = getCampuses();
$departments = getDepartments();

$pageTitle   = 'Research Documents';
$sidebarNav  = researchNav();
$user        = currentUser();
$pageActions = '<button class="btn btn-primary" onclick="openModal(\'resModal\')">+ Upload</button>';
require __DIR__ . '/../../includes/layout.php';
?>

<div class="card">
    <div class="card-header">All Documents</div>
    <div class="card-body table-wrap" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Department</th>
                    <th>File</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($r = $rows->fetch_assoc()):
                $statusClass = 'badge-' . strtolower($r['status']);
            ?>
                <tr>
                    <td class="doc-title"><?= e($r['title']) ?></td>
                    <td class="doc-authors-cell"><?= e($r['authors']) ?></td>
                    <td><span class="badge <?= $statusClass ?>"><?= ucfirst(e($r['status'])) ?></span></td>
                    <td><?= e($r['campus'] ?? '—') ?></td>
                    <td><?= e($r['department'] ?? '—') ?></td>
                    <td>
                        <?php if ($r['file_path']): ?>
                        <a class="doc-download"
                           href="<?= APP_URL ?>/uploads/research/<?= e($r['file_path']) ?>"
                           target="_blank">Download</a>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td class="doc-date"><?= e(date('M j, Y', strtotime($r['updated_at']))) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal-overlay" id="resModal">
    <div class="modal">
        <form method="POST" action="<?= APP_URL ?>/actions/handler.php" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
            <input type="hidden" name="action"     value="save_research">

            <div class="modal-header">
                <span>Upload Research</span>
                <button type="button" onclick="closeModal('resModal')">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Authors</label>
                    <input name="authors" class="form-control">
                </div>
                <div class="form-group">
                    <label>Abstract</label>
                    <textarea name="abstract" class="form-control"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Document (PDF / DOC)</label>
                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Campus</label>
                        <select name="campus_id" class="form-control">
                            <option value="">— Select —</option>
                            <?php foreach ($campuses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <select name="department_id" class="form-control">
                            <option value="">— Select —</option>
                            <?php foreach ($departments as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('resModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>