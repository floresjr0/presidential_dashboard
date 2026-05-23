<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['guidance','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats      = getDashboardStats();
$pageTitle  = 'Guidance Office Dashboard';
$sidebarNav = guidanceNav();
$user       = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>

<?php
$statsContext = 'guidance';
require __DIR__ . '/../../includes/stats_cards.php';
?>

<div class="card">
    <div class="card-header">Gender Ratio</div>
    <div class="card-body">
        <canvas id="gChart"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () =>
    initChart('gChart', 'pie', ['Male', 'Female'], [<?= $stats['male_students'] ?>, <?= $stats['female_students'] ?>])
);
</script>

<?php require __DIR__ . '/../../includes/layout_end.php'; ?>