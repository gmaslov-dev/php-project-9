<?php

namespace Hexlet\Code\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PageController extends BaseController
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');

        $data = [
            'title' => 'Home',
            'errors' => [],
            'url' => '',
            'current_path' => $request->getUri()->getPath()
        ];

        return $this->render($response, 'pages/index.twig', $data);
    }
}
