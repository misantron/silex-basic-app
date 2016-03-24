<?php

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/cache/config.php';

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

foreach($providers as $providerClassName){
    /** @var \Silex\ServiceProviderInterface $provider */
    $provider = new $providerClassName;
    $app->register($provider, $config);
}

return $app;