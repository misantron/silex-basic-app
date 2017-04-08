<?php

namespace App\Tests\Base\Provider;

use App\Base\Console\ConsoleApplication;
use App\Base\Provider\ConsoleServiceProvider;
use App\Tests\BaseTestCase;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Misantron\Silex\Provider\Adapter\PhpConfigAdapter;
use Misantron\Silex\Provider\ConfigServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
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
        $this->app->register(new DoctrineServiceProvider());
    }

    public function testRegister()
    {
        $this->app->register(new ConsoleServiceProvider());

        /** @var ConsoleApplication $console */
        $console = $this->app['console'];

        $this->assertInstanceOf(ConsoleApplication::class, $console);
        $this->assertInstanceOf(Application::class, $console->getSilexApplication());
        $this->assertInstanceOf(HelperSet::class, $console->getHelperSet());

        $this->assertEquals('Application console', $console->getName());
        $this->assertEquals('1.0.0', $console->getVersion());

        $this->assertInstanceOf(GenerateCommand::class, $console->get('migrations:generate'));
        $this->assertInstanceOf(MigrateCommand::class, $console->get('migrations:migrate'));

        $this->assertArrayHasKey('help', $console->all());
        $this->assertArrayHasKey('list', $console->all());
        $this->assertArrayHasKey('migrations:generate', $console->all());
    }
}