<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['hr','admin']);
require_once __DIR__ . '/../../includes/nav.php';

$stats        = getDashboardStats();
$statsContext = 'hr';
$pageTitle    = 'HR Dashboard';
$sidebarNav   = hrNav();
$user         = currentUser();
require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>

<div class="card">
    <div class="card-header">Quick Actions</div>
    <div class="card-body" style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/modules/hr/employees.php" class="btn btn-primary">Manage Employees</a>
    </div>
</div>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>