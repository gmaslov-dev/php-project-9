<?php

namespace Hexlet\Code\Controller;

use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PageController
{
    public function __construct(private Twig $twig)
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'pages/index.twig', [
            'title' => 'Home',
            'content' => 'Home'
        ]);
    }
}
