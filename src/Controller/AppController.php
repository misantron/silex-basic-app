<?php

namespace App\Controller;

use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;

class AppController implements AppControllerInterface
{
    /** @var Twig_Environment */
    protected $twigEngine;

    public function __construct($twigEngine)
    {
        $this->twigEngine = $twigEngine;
    }

    /**
     * @param ControllerCollection $controllers
     * @param string $controllerId
     */
    public static function connect($controllers, $controllerId)
    {
        $controllers->get('/', $controllerId . ":indexAction");
    }

    public function indexAction(Request $request)
    {
        $this->twigEngine->render('index', []);
    }
}