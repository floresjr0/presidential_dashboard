<?php
require_once __DIR__ . '/../../config/app.php';
requireLogin();
require_once __DIR__ . '/../../includes/nav.php';
$role = $_SESSION['role'];
$sidebarNav = in_array($role, ['research','admin']) ? researchNav() : presidentNav();
$search = trim($_GET['q'] ?? '');
$db = getDB();
$sql = "SELECT r.*, c.name as campus FROM research_documents r LEFT JOIN campuses c ON r.campus_id=c.id WHERE r.status != 'archived'";
if ($search) {
    $s = "%$search%";
    $stmt = $db->prepare("$sql AND (r.title LIKE ? OR r.authors LIKE ?) ORDER BY r.created_at DESC");
    $stmt->bind_param('ss', $s, $s);
    $stmt->execute();
    $rows = $stmt->get_result();
} else {
    $rows = $db->query("$sql ORDER BY r.created_at DESC");
}
$pageTitle = 'Research Library';
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<form class="filters" method="GET">
<div class="form-group" style="flex:1;"><input name="q" class="form-control" placeholder="Search research title or author..." value="<?= e($search) ?>"></div>
<button type="submit" class="btn btn-primary">Search</button>
</form>
<div class="grid-2">
<?php while ($r = $rows->fetch_assoc()): ?>
<div class="card">
<div class="card-header"><?= e($r['title']) ?> <span class="badge badge-info"><?= e($r['status']) ?></span></div>
<div class="card-body">
<p class="text-muted"><strong>Authors:</strong> <?= e($r['authors']) ?></p>
<p><?= e(substr($r['abstract']??'', 0, 200)) ?>...</p>
<p><small>Campus: <?= e($r['campus']??'N/A') ?></small></p>
<?php if ($r['file_path']): ?><a href="<?= APP_URL ?>/uploads/research/<?= e($r['file_path']) ?>" class="btn btn-sm btn-primary" target="_blank">View / Download</a><?php endif; ?>
</div></div>
<?php endwhile; ?>
</div>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
