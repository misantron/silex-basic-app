<?php

namespace App\Tests\Controller;

use Silex\WebTestCase;

class AppControllerTest extends WebTestCase
{
    public function createApplication()
    {
        $this->app = require_once __DIR__ . '/../../app/app.php';

        $this->app['session.test'] = true;

        return $this->app;
    }

    public function testIndexAction()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }
}