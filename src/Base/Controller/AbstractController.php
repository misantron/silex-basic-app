<?php

namespace App\Base\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @package App\Base\Controller
 */
abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param RequestStack $requestStack
     * @param \Twig_Environment $twig
     */
    public function __construct(RequestStack $requestStack, \Twig_Environment $twig)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function json(array $data = [], $status = Response::HTTP_OK, array $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function render($template, array $params = [])
    {
        $route = $this->request->get('_controller');
        list($controller) = explode(':', $route, 2);
        $controller = explode('.', $controller, 2);

        return $this->twig->render(sprintf('%s/%s.twig', reset($controller), $template), $params);
    }
}