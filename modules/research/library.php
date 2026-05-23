<?php
require_once __DIR__ . '/../../config/app.php';
requireLogin();
require_once __DIR__ . '/../../includes/nav.php';

$role       = $_SESSION['role'];
$sidebarNav = in_array($role, ['research','admin']) ? researchNav() : presidentNav();
$search     = trim($_GET['q'] ?? '');
$status     = trim($_GET['status'] ?? '');
$db         = getDB();

$sql = "SELECT r.*, c.name AS campus FROM research_documents r
        LEFT JOIN campuses c ON r.campus_id = c.id
        WHERE r.status != 'archived'";

$params = [];
$types  = '';

if ($search) {
    $sql    .= " AND (r.title LIKE ? OR r.authors LIKE ?)";
    $s       = "%$search%";
    $params  = [$s, $s];
    $types  .= 'ss';
}
if ($status) {
    $sql    .= " AND r.status = ?";
    $params[] = $status;
    $types   .= 's';
}
$sql .= " ORDER BY r.created_at DESC";

if ($params) {
    $stmt = $db->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $rows = $stmt->get_result();
} else {
    $rows = $db->query($sql);
}

$pageTitle = 'Research Library';
$user      = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>

<div class="filters">
    <div class="form-group" style="flex:1;min-width:200px;">
        <label>Search</label>
        <input name="q" class="form-control" placeholder="Title or author..." value="<?= e($search) ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="">All</option>
            <?php foreach (['ongoing','completed','published'] as $s): ?>
            <option value="<?= $s ?>" <?= $status === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group" style="align-self:flex-end;">
        <button type="submit" class="btn btn-primary" onclick="applyFilters()">Search</button>
    </div>
</div>

<div class="grid-2">
<?php
$count = 0;
while ($r = $rows->fetch_assoc()):
    $count++;
    $statusClass = 'badge-' . strtolower($r['status']);
?>
    <div class="card">
        <div class="card-header">
            <span style="flex:1;line-height:1.4;"><?= e($r['title']) ?></span>
            <span class="badge <?= $statusClass ?>"><?= ucfirst(e($r['status'])) ?></span>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
            <p class="doc-authors"><strong>Authors:</strong> <?= e($r['authors']) ?></p>
            <?php if (!empty($r['abstract'])): ?>
            <p class="doc-abstract"><?= e(substr($r['abstract'], 0, 220)) ?>…</p>
            <?php endif; ?>
            <p class="doc-campus">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                <?= e($r['campus'] ?? 'N/A') ?>
            </p>
            <?php if ($r['file_path']): ?>
            <a href="<?= APP_URL ?>/uploads/research/<?= e($r['file_path']) ?>"
               class="btn btn-sm btn-primary" target="_blank" style="margin-top:auto;align-self:flex-start;">
                View / Download
            </a>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>

<?php if ($count === 0): ?>
    <div class="empty-state">
        <strong>No research found</strong>
        <p>Try adjusting your search or filter.</p>
    </div>
<?php endif; ?>
</div>

<script>
function applyFilters() {
    const q      = document.querySelector('input[name="q"]').value;
    const status = document.querySelector('select[name="status"]').value;
    const url    = new URL(window.location.href);
    url.searchParams.set('q', q);
    url.searchParams.set('status', status);
    window.location.href = url.toString();
}
</script>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>