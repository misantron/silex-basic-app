<?php

use Silex\Application;
use Silex\ServiceProviderInterface;


require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/cache/config.php';

umask(0);
ini_set('intl.default_locale', $config['intl.default_locale']);
setlocale(LC_ALL, $config['intl.default_locale']);
ini_set('date.timezone', $config['date.timezone']);
date_default_timezone_set($config['date.timezone']);

$app = new Application();

$providers = array_merge(
    $config['vendor.providers'],
    $config['app.providers']
);

foreach($providers as $providerClassName){
    /** @var ServiceProviderInterface $provider */
    $provider = new $providerClassName;
    $app->register($provider, $config);
}

return $app;