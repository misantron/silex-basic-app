<?php

define('ROOT_PATH', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';

$env = getenv('APP_ENV') ?: 'dev';

$app = new \Silex\Application();

$app->register(new \App\Base\Provider\Service\ConfigServiceProvider(
    __DIR__ . "/config/app.{$env}.php"
));

umask(0);
ini_set('intl.default_locale', $app['intl.default_locale']);
setlocale(LC_ALL, $app['intl.default_locale']);
ini_set('date.timezone', $app['date.timezone']);
date_default_timezone_set($app['date.timezone']);

if ($app['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_USER_DEPRECATED);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app->register(new \Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => $app['db.options']
]);
$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path' => [ ROOT_PATH . '/app/templates'],
    'twig.options' => [
        'cache' => ROOT_PATH . '/app/cache/twig'
    ],
]);
$app->register(new \Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => ROOT_PATH . '/app/logs/application.log',
    'monolog.level' => $app['log.level'],
    'monolog.name' => 'application'
]);

$servicesLoader = new \App\Base\Service\ServicesLoader($app);
$servicesLoader->bind();

$routesLoader = new \App\Base\Service\RoutesLoader($app);
$routesLoader->bind();

return $app;