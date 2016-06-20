<?php

namespace App\Tests\Base\Console;

use App\Base\Console\ConsoleApplication;
use App\Tests\BaseTestCase;
use Silex\Application;

class ConsoleApplicationTest extends BaseTestCase
{
    public function testConstructor()
    {
        $console = new ConsoleApplication($this->app, 'Console test', '1.0');
        
        $this->assertInstanceOf(Application::class, $console->getSilexApplication());
    }
}