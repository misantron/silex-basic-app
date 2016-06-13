<?php

namespace App\Base\Service;

use Pimple\Container;
use Silex\Application;

abstract class AbstractServiceLoader
{
    /** @var Container|Application */
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    abstract public function bind();
}