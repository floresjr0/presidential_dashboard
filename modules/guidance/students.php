<?php
require_once __DIR__ . '/../../config/app.php';
requireRole(['guidance','admin']);
header('Location: ' . APP_URL . '/modules/registrar/students.php');
exit;
