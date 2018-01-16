<?php

namespace Application\Tests\Controller;


use Application\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AppControllerTest extends WebTestCase
{
    public function createApplication()
    {
        $this->app = require __DIR__ . '/../../app/app.php';

        $this->app['session.test'] = true;
        $this->app['debug'] = false;

        return $this->app;
    }

    public function testIndex()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testNotFound()
    {
        $client = $this->createClient();
        $client->request('GET', '/not-exists');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals(Response::$statusTexts[Response::HTTP_NOT_FOUND], $response->getContent());
    }
}