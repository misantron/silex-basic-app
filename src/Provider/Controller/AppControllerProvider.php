<?php

namespace App\Provider\Controller;

use App\Controller\AppController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;

class AppControllerProvider implements ServiceProviderInterface, ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\AppController:indexAction');

        return $controllers;
    }

    public function register(Application $app)
    {
        $app['app.controller'] = $app->share(function ($app) {
            return new AppController(
                $app['twig']
            );
        });
        $app->mount('/', $this);
    }

    public function boot(Application $app) {}
}