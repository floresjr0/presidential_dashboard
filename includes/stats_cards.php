<?php /** @var array $stats */ ?>
<div class="stats-grid">
    <div class="stat-card"><div class="label">Total Students</div><div class="value"><?= number_format($stats['students']) ?></div><div class="sub">Enrolled: <?= $stats['enrolled'] ?> | Graduating: <?= $stats['graduating'] ?></div></div>
    <div class="stat-card accent"><div class="label">Instructors</div><div class="value"><?= number_format($stats['instructors']) ?></div><div class="sub">M: <?= $stats['male_instructors'] ?> | F: <?= $stats['female_instructors'] ?></div></div>
    <div class="stat-card success"><div class="label">Non-Teaching Staff</div><div class="value"><?= number_format($stats['non_teaching']) ?></div></div>
    <div class="stat-card"><div class="label">Admin Staff</div><div class="value"><?= number_format($stats['admin_staff']) ?></div></div>
    <div class="stat-card warning"><div class="label">BASCAT Takers</div><div class="value"><?= number_format($stats['bascat']) ?></div></div>
    <div class="stat-card danger"><div class="label">Drop / Withdrawal</div><div class="value"><?= number_format($stats['dropped']) ?></div></div>
    <div class="stat-card success"><div class="label">Revenue</div><div class="value">₱<?= number_format($stats['revenue'], 2) ?></div></div>
    <div class="stat-card danger"><div class="label">Expenses</div><div class="value">₱<?= number_format($stats['expenses'], 2) ?></div></div>
    <div class="stat-card"><div class="label">Research Ongoing</div><div class="value"><?= $stats['research_ongoing'] ?></div><div class="sub">Completed: <?= $stats['research_completed'] ?> | Published: <?= $stats['research_published'] ?></div></div>
</div>
