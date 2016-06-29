<?php

namespace App\Controller;

use App\Base\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

class AppController extends BaseController
{
    public function indexAction()
    {
        return new Response($this->twig->render('app/index.twig'));
    }

    public function errorAction(\Exception $e, $request, $code)
    {
        $this->logger->addError($e->getMessage());
        $this->logger->addError($e->getTraceAsString());

        return new Response($this->twig->render('app/error.twig', [
            'statusCode' => $code,
            'message' => $e->getMessage(),
            'stackTrace' => $e->getTraceAsString(),
        ]), $code);
    }
}