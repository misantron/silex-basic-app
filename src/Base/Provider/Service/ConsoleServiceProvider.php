<?php

namespace App\Base\Provider\Service;

use App\Base\Console\ConsoleApplication;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

class ConsoleServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['console'] = function() use ($app) {

            $helperSet = new HelperSet([
                'question' => new QuestionHelper(),
            ]);
            /** @var Application $app */
            $application = new ConsoleApplication($app, $app['console.name'], $app['console.version']);
            $application->setCatchExceptions(true);
            $application->setHelperSet($helperSet);
            
            return $application;
        };
    }
}