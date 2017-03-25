<?php

namespace App\Provider;


use App\Controller\AppController;
use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $app->error(function (\Exception $e, Request $request, $code) use ($app) {

            /** @var Logger $logger */
            $logger = $app['monolog'];
            $logger->error($e->getMessage());

            if ($request->isXmlHttpRequest()) {
                return $app->json([
                    'message' => $app['debug'] ? $e->getMessage() : Response::$statusTexts[$code]
                ], $code);
            } else {
                return new Response($app['debug'] ? $e->getMessage() : Response::$statusTexts[$code], $code);
            }
        });

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