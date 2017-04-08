<?php

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application([
    'env' => getenv('APP_ENV') ?: 'dev',
    'user' => null
]);

$app->register(new \Misantron\Silex\Provider\ConfigServiceProvider(
    new \Misantron\Silex\Provider\Adapter\PhpConfigAdapter(),
    [
        ROOT_PATH . '/app/config/app.' . $app['env'] . '.php'
    ],
    ['ROOT_PATH' => ROOT_PATH]
));

umask(0);
ini_set('intl.default_locale', $app['config']['intl.default_locale']);
setlocale(LC_ALL, $app['config']['intl.default_locale']);
ini_set('date.timezone', $app['config']['date.timezone']);
date_default_timezone_set($app['config']['date.timezone']);

// @codeCoverageIgnoreStart
if ($app['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_USER_DEPRECATED);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
// @codeCoverageIgnoreEnd

$app->register(new \Silex\Provider\SessionServiceProvider());
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(new \Silex\Provider\TwigServiceProvider(), $app['config']['twig']);
$app->register(new \Silex\Provider\MonologServiceProvider(), $app['config']['monolog']);

$app->register(new \App\Provider\ControllersProvider());

return $app;