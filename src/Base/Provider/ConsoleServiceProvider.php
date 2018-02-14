<?php

namespace Application\Base\Provider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Class ConsoleServiceProvider
 * @package Application\Base\Provider
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['console'] = function ($app) {

            $name = $app['console.name'] ?? 'Application console';
            $version = $app['console.version'] ?? '1.0.0';

            $console = new Application($name, $version);
            $console->setCatchExceptions(true);
            $console->setHelperSet(new HelperSet([
                'question' => new QuestionHelper(),
            ]));

            return $console;
        };
    }
}