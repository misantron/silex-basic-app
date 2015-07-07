<?php

namespace App\Task;

use Silex\Application;
use Task;

abstract class AbstractTask extends Task
{
    /** @var string  */
    protected $env = 'prod';
    /** @var string */
    protected $bootstrap;

    /** @var Application */
    private static $app;

    /**
     * @param string $value
     */
    public function setEnv($value)
    {
        $this->env = $value;
    }

    /**
     * @param string $value
     */
    public function setBootstrap($value)
    {
        $this->bootstrap = $value;
    }

    public function main()
    {
        if (static::$app === null) {
            $bootstrap = include_once $this->bootstrap;
            static::$app = $bootstrap;
        }
        $this->execute(static::$app);
    }

    abstract function execute(Application $app);
}