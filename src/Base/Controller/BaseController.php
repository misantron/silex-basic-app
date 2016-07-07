<?php

namespace App\Base\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseController
{
    /** @var Request */
    protected $request;
    /** @var \Twig_Environment */
    protected $twig;
    /** @var Logger */
    protected $logger;

    public function __construct(RequestStack $requestStack, $twig, $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
        $this->logger = $logger;
    }
    
    protected function render($template, $params = [])
    {
        return $this->twig->render(sprintf('%s/%s.twig', $this->getController(), $template), $params);
    }
    
    private function getController()
    {
        $class = explode('\\', static::class);
        $className = end($class);
        $controller = str_replace('Controller', '', $className);

        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $controller)), '_');
    }
}