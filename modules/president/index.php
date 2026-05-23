<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['president','admin']);
require_once __DIR__ . '/../../includes/nav.php';

$campusFilter   = isset($_GET['campus']) ? (int)$_GET['campus'] : null;
$ayFilter       = isset($_GET['ay'])     ? (int)$_GET['ay']     : null;
$stats          = getDashboardStats($campusFilter, $ayFilter);
$campuses       = getCampuses();
$academicYears  = getAcademicYears();

$pageTitle  = 'Executive Dashboard';
$pageCSS    = 'modules/president/index.css';
$sidebarNav = presidentNav();
$user       = currentUser();

require __DIR__ . '/../../includes/layout.php';
require __DIR__ . '/../../includes/stats_cards.php';
?>

<div class="filters">
    <div class="form-group">
        <label>Campus</label>
        <select class="form-control" data-campus-filter onchange="location.href='?campus='+this.value+'&ay=<?= $ayFilter ?? '' ?>'">
            <option value="">All Campuses</option>
            <?php foreach ($campuses as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $campusFilter == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Academic Year</label>
        <select class="form-control" onchange="location.href='?campus=<?= $campusFilter ?? '' ?>&ay='+this.value">
            <option value="">All Years</option>
            <?php foreach ($academicYears as $ay): ?>
            <option value="<?= $ay['id'] ?>" <?= $ayFilter == $ay['id'] ? 'selected' : '' ?>><?= e($ay['year_label']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="charts-grid">
    <div class="card">
        <div class="card-header">Gender Distribution — Students</div>
        <div class="card-body"><div class="chart-container"><canvas id="chartGenderStudents"></canvas></div></div>
    </div>
    <div class="card">
        <div class="card-header">Population by Campus</div>
        <div class="card-body"><div class="chart-container"><canvas id="chartCampus"></canvas></div></div>
    </div>
    <div class="card">
        <div class="card-header">Student Status Breakdown</div>
        <div class="card-body"><div class="chart-container"><canvas id="chartStatus"></canvas></div></div>
    </div>
    <div class="card">
        <div class="card-header">Finance Overview</div>
        <div class="card-body"><div class="chart-container"><canvas id="chartFinance"></canvas></div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">Campus Population Summary</div>
    <div class="card-body table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Campus</th>
                    <th>Code</th>
                    <th>Students</th>
                    <th>Employees</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($stats['by_campus'] as $c): ?>
            <tr>
                <td><span class="campus-name"><?= e($c['name']) ?></span></td>
                <td><span class="campus-code"><?= e($c['code']) ?></span></td>
                <td><span class="campus-count"><?= number_format($c['students']) ?></span></td>
                <td><span class="campus-count"><?= number_format($c['employees']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initChart('chartGenderStudents', 'doughnut',
        ['Male', 'Female', 'Other'],
        [<?= $stats['male_students'] ?>, <?= $stats['female_students'] ?>, <?= max(0, $stats['students'] - $stats['male_students'] - $stats['female_students']) ?>]
    );
    initChart('chartCampus', 'bar',
        <?= json_encode(array_column($stats['by_campus'], 'code')) ?>,
        <?= json_encode(array_map('intval', array_column($stats['by_campus'], 'students'))) ?>
    );
    initChart('chartStatus', 'pie',
        ['Enrolled', 'Graduating', 'BASCAT', 'Dropped', 'Graduated'],
        [<?= $stats['enrolled'] ?>, <?= $stats['graduating'] ?>, <?= $stats['bascat'] ?>, <?= $stats['dropped'] ?>, <?= $stats['graduated'] ?>]
    );
    initChart('chartFinance', 'bar',
        ['Revenue', 'Expenses', 'Budget'],
        [<?= $stats['revenue'] ?>, <?= $stats['expenses'] ?>, <?= $stats['budget'] ?>]
    );
});
</script>
<?php require __DIR__ . '/../../includes/layout_end.php'; ?>