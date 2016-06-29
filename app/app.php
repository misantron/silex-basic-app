<?php

define('ROOT_PATH', __DIR__ . '/..');

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application([
    'env' => getenv('APP_ENV') ?: 'dev'
]);

$app->register(new \App\Base\Provider\ConfigServiceProvider(
    __DIR__ . "/config/app.{$app['env']}.php",
    ['ROOT_PATH' => ROOT_PATH]
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

$app->register(new \Silex\Provider\SessionServiceProvider());
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(new \Silex\Provider\TwigServiceProvider(), $app['twig.config']);
$app->register(new \Silex\Provider\MonologServiceProvider(), $app['monolog.config']);

$routesLoader = new \App\Loader\AppRoutesLoader($app);
$routesLoader->bind();

return $app;