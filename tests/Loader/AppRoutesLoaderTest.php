<?php

namespace App\Tests\Base\Service;

use App\Controller\AppController;
use App\Loader\AppRoutesLoader;
use App\Tests\BaseTestCase;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;

class AppRoutesLoaderTest extends BaseTestCase
{
    /** @var AppRoutesLoader */
    protected $loader;

    public function setUp()
    {
        parent::setUp();

        $this->app->register(new TwigServiceProvider());
        $this->app->register(new MonologServiceProvider());

        $this->loader = new AppRoutesLoader($this->app);
    }

    public function testConstructor()
    {
        $app = $this->getPropertyValue($this->loader, 'app');

        $this->assertInstanceOf(Application::class, $app);
        $this->assertInstanceOf(AppController::class, $app['app.controller']);
    }
}