<?php
require_once __DIR__ . '/config/app.php';
requireLogin();
redirect(roleDashboardPath($_SESSION['role']));
