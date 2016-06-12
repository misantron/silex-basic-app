<?php

namespace App\Provider\Controller;

use App\Base\Controller\AppController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

class AppControllerProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /** @var Application $app */
        $app['app.controller'] = function() use ($app) {
            return new AppController(
                $app['twig']
            );
        };
        $app->get('/', 'app.controller:indexAction');
    }
}