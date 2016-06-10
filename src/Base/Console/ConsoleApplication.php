<?php

namespace App\Base\Console;

use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    /** @var \Silex\Application */
    private $silexApplication;

    public function __construct(\Silex\Application $application, $name, $version)
    {
        parent::__construct($name, $version);

        $this->silexApplication = $application;

        $application->boot();
    }

    public function getSilexApplication()
    {
        return $this->silexApplication;
    }
}