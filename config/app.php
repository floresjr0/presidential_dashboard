<?php
define('APP_NAME', 'University Executive Dashboard');
define('APP_URL', '/university_dashboard');
define('UPLOAD_PATH', __DIR__ . '/../uploads/research/');
define('UPLOAD_URL', APP_URL . '/uploads/research/');

session_start();

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';