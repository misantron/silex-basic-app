<?php

ini_set('display_errors', 0);
$app = require_once __DIR__ . '/../app/app.php';
require __DIR__ . '/../app/cache/config.php';
$app->run();