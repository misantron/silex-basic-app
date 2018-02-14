<?php

namespace Application\Tests\Base\Provider;

use Application\Base\Provider\ConsoleServiceProvider;
use Application\Tests\BaseTestCase;
use Misantron\Silex\Provider\Adapter\PhpConfigAdapter;
use Misantron\Silex\Provider\ConfigServiceProvider;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

class ConsoleServiceProviderTest extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->app->register(new ConfigServiceProvider(
            new PhpConfigAdapter(),
            [
                __DIR__ . '/../../../app/config/app.dev.php'
            ],
            ['ROOT_PATH' => realpath(__DIR__ . '/../../../')]
        ));
    }

    public function testRegister()
    {
        $this->app->register(new ConsoleServiceProvider());

        /** @var Application $console */
        $console = $this->app['console'];

        $this->assertInstanceOf(Application::class, $console);
        $this->assertInstanceOf(HelperSet::class, $console->getHelperSet());

        $this->assertEquals('Application console', $console->getName());
        $this->assertEquals('1.0.0', $console->getVersion());

        $this->assertArrayHasKey('help', $console->all());
        $this->assertArrayHasKey('list', $console->all());
    }
}