<?php
require_once __DIR__ . '/config/app.php';
logoutUser();
redirect('/index.php');
