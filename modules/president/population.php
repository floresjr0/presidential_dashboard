<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['president','admin']);
require_once __DIR__ . '/../../includes/nav.php';
$stats = getDashboardStats();
$pageTitle = 'Population Monitoring';
$sidebarNav = presidentNav();
$user = currentUser();
require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>
<div class="grid-2">
    <div class="card"><div class="card-header">Employees by Gender</div><div class="card-body"><div class="chart-container"><canvas id="c1"></canvas></div></div></div>
    <div class="card"><div class="card-header">Per Institute (Students)</div><div class="card-body table-wrap">
        <table><thead><tr><th>Institute</th><th>Campus</th><th>Students</th></tr></thead><tbody>
        <?php foreach ($stats['by_institute'] as $i): ?><tr><td><?= e($i['name']) ?></td><td><?= e($i['campus_name']) ?></td><td><?= $i['students'] ?></td></tr><?php endforeach; ?>
        </tbody></table>
    </div></div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>initChart('c1','doughnut',['Male Instructors','Female Instructors','Male Staff','Female Staff'],[<?= $stats['male_instructors']?>,<?= $stats['female_instructors']?>,<?= $stats['male_staff']?>,<?= $stats['female_staff']?>]));</script>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>
