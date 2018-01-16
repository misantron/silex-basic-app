<?php

namespace Application\Controller;

use Application\Base\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function index()
    {
        return new Response($this->render('index'));
    }
}