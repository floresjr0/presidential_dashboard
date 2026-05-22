<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['guidance','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats = getDashboardStats();
$pageTitle = 'Guidance Office Dashboard';
$sidebarNav = guidanceNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
?>
<div class="stats-grid">
    <div class="stat-card"><div class="label">Total Students</div><div class="value"><?= $stats['students'] ?></div></div>
    <div class="stat-card"><div class="label">Male Students</div><div class="value"><?= $stats['male_students'] ?></div></div>
    <div class="stat-card accent"><div class="label">Female Students</div><div class="value"><?= $stats['female_students'] ?></div></div>
    <div class="stat-card danger"><div class="label">Dropped</div><div class="value"><?= $stats['dropped'] ?></div></div>
</div>
<div class="card"><div class="card-header">Gender Ratio</div><div class="card-body"><div class="chart-container"><canvas id="gChart"></canvas></div></div></div>
<script>document.addEventListener('DOMContentLoaded',()=>initChart('gChart','pie',['Male','Female'],[<?= $stats['male_students']?>,<?= $stats['female_students']?>]));</script>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
