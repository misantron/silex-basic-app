<?php

namespace App\Controller;

use App\Base\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends BaseController
{
    public function index()
    {
        return new Response($this->render('index'));
    }

    public function error(\Exception $e, Request $request, $code)
    {
        $this->logger->addError($e->getMessage());
        $this->logger->addError($e->getTraceAsString());

        return new Response($this->render('error', [
            'statusCode' => $code,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]), $code);
    }
}