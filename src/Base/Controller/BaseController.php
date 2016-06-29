<?php

namespace App\Base\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;

class BaseController
{
    /** @var Request */
    protected $request;
    /** @var \Twig_Environment */
    protected $twig;
    /** @var Logger */
    protected $logger;

    public function __construct($request, $twig, $logger)
    {
        $this->request = $request;
        $this->twig = $twig;
        $this->logger = $logger;
    }
}