<?php
require_once __DIR__ . '/header.php';
?>
<div class="app-layout">
<?php require_once __DIR__ . '/sidebar.php'; ?>
<main class="main-content">
    <header class="page-header">
        <h1><?= e($pageTitle ?? 'Dashboard') ?></h1>
        <?php if (!empty($pageActions)): ?>
        <div class="page-actions"><?= $pageActions ?></div>
        <?php endif; ?>
    </header>
    <div class="page-body">
