<?php

namespace Application\Provider;


use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ServicesProvider
 * @package Application\Provider
 */
class ServicesProvider implements ServiceProviderInterface
{
    /**
     * @param Container|Application $app
     */
    public function register(Container $app)
    {
        // error handler
        $app->error(function (\Exception $e, Request $request, int $code) use ($app) {

            /** @var Logger $logger */
            $logger = $app['monolog'];
            $logger->error($e->getMessage(), ['request' => $request]);

            $message = $app['debug'] ? $e->getMessage() : Response::$statusTexts[$code];

            if ($request->isXmlHttpRequest()) {
                return $app->json(['message' => $message], $code);
            } else {
                return new Response($message, $code);
            }
        });
    }
}