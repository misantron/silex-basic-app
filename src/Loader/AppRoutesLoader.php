<?php

namespace App\Loader;

use App\Base\Service\AbstractServicesLoader;
use App\Controller\AppController;
use Pimple\Container;

class AppRoutesLoader extends AbstractServicesLoader
{
    public function __construct(Container $app)
    {
        parent::__construct($app);
        $this->instantiateControllers();
    }

    public function bind()
    {
        $this->app->get('/', 'app.controller:indexAction');
        $this->app->error('app.controller:errorAction');
    }

    private function instantiateControllers()
    {
        $this->app['app.controller'] = function() {
            return new AppController(
                $this->app['request_stack']->getCurrentRequest(),
                $this->app['twig'],
                $this->app['monolog']
            );
        };
    }
}