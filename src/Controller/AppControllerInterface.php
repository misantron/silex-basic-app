<?php

namespace App\Controller;

use Silex\ControllerCollection;

interface AppControllerInterface
{
    /**
     * @param ControllerCollection $controllers
     * @param string $controllerId
     */
    public static function connect($controllers, $controllerId);
}