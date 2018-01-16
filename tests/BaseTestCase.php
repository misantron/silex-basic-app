<?php

namespace Application\Tests;

use PHPUnit\Framework\TestCase;
use Silex\Application;

abstract class BaseTestCase extends TestCase
{
    /** @var Application */
    protected $app;

    protected function setUp()
    {
        parent::setUp();

        $this->app = new Application();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->app = null;
    }
    
    protected function callMethod($obj, $name, $args = [])
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs(null, $args);
    }

    protected function getPropertyValue($obj, $name)
    {
        $property = new \ReflectionProperty($obj, $name);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }
}