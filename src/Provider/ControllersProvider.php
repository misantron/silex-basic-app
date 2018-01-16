<?php

namespace Application\Provider;


use Application\Controller\AppController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * Class ControllersProvider
 * @package Application\Provider
 */
class ControllersProvider implements ServiceProviderInterface, ControllerProviderInterface, BootableProviderInterface
{
    /**
     * @param Application $app
     * @return ControllerCollection
     */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'app.controller:index');

        return $controllers;
    }

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['app.controller'] = function ($app) {
            return new AppController(
                $app['request_stack'],
                $app['twig']
            );
        };
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
        $app->mount('/', $this->connect($app));
    }
}