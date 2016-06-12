<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/cache/config.php';

umask(0);
ini_set('intl.default_locale', $config['intl.default_locale']);
setlocale(LC_ALL, $config['intl.default_locale']);
ini_set('date.timezone', $config['date.timezone']);
date_default_timezone_set($config['date.timezone']);

$app = new \Silex\Application();

$providers = array_merge(
    $config['providers']['vendor'],
    $config['providers']['app']
);

foreach($providers as $provider) {
    $app->register(new $provider, $config);
}

return $app;