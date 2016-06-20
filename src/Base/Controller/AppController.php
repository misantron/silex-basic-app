<?php

namespace App\Base\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController
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

    public function indexAction()
    {
        return new Response($this->twig->render('index.twig'));
    }

    public function errorAction(\Exception $e, $code)
    {
        $this->logger->addError($e->getMessage());
        $this->logger->addError($e->getTraceAsString());

        return new Response($this->twig->render('error.twig', [
            'statusCode' => $code,
            'message' => $e->getMessage(),
            'stackTrace' => $e->getTraceAsString(),
        ]), $code);
    }
}