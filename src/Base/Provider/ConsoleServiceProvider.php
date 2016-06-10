<?php

namespace App\Base\Provider;

use App\Base\Console\ConsoleApplication;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

class ConsoleServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['console'] = function() use ($app) {
            /** @var Application $app */
            return new ConsoleApplication($app, $app['console.name'], $app['console.version']);
        };
    }
}