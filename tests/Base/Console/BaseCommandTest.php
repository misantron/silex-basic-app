<?php

namespace App\Tests\Base\Console;

use App\Base\Console\BaseCommand;
use App\Base\Console\ConsoleApplication;
use App\Tests\BaseTestCase;
use Silex\Application;

class BaseCommandTest extends BaseTestCase
{
    public function testGetBaseApplication()
    {
        $console = new ConsoleApplication($this->app, 'Console test', '1.0');
        $console->add(new BaseCommand('base.command'));

        /** @var BaseCommand $command */
        $command = $console->get('base.command');

        $this->assertInstanceOf(BaseCommand::class, $command);
        $this->assertInstanceOf(Application::class, $command->getBaseApplication());
    }
}