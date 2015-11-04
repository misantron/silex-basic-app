<?php

namespace App\Controller;

use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;

class AppController
{
    /** @var Twig_Environment */
    protected $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function indexAction(Request $request)
    {
        $this->twig->render('index', []);
    }
}