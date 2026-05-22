    <script src="<?= APP_URL ?>/assets/js/app.js"></script>
    <?php if (!empty($pageScripts)): foreach ($pageScripts as $s): ?>
    <script src="<?= APP_URL ?>/assets/js/<?= e($s) ?>"></script>
    <?php endforeach; endif; ?>
</body>
</html>
