<?php
$role = $user['role'] ?? '';
$nav = $sidebarNav ?? [];

function navActive(string $path): string {
    $current = $_SERVER['REQUEST_URI'] ?? '';
    return str_contains($current, $path) ? 'active' : '';
}
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="brand-icon">UD</span>
        <div>
            <strong>University</strong>
            <small>Executive Dashboard</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($nav as $item): ?>
        <a href="<?= APP_URL . e($item['href']) ?>" class="<?= navActive($item['href']) ?>">
            <span class="nav-icon"><?= $item['icon'] ?? '•' ?></span>
            <?= e($item['label']) ?>
        </a>
        <?php endforeach; ?>
    </nav>
    <div class="sidebar-user">
        <div class="user-info">
            <strong><?= e($user['full_name']) ?></strong>
            <small><?= e(roleLabel($role)) ?></small>
        </div>
        <a href="<?= APP_URL ?>/logout.php" class="btn-logout">Logout</a>
    </div>
</aside>
