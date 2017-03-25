<?php

namespace App\Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\HttpKernelInterface;

abstract class WebTestCase extends TestCase
{
    /**
     * @var HttpKernelInterface
     */
    protected $app;

    protected function setUp()
    {
        $this->app = $this->createApplication();
    }

    public function createClient(array $server = [])
    {
        return new Client($this->app, $server);
    }

    abstract public function createApplication();
}