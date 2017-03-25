<?php

namespace App\Controller;

use App\Base\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
    public function index()
    {
        return new Response($this->render('index'));
    }
}