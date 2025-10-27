<?php

namespace Hexlet\Code\Controller;

use Slim\Views\Twig;
use Hexlet\Code\Database\Connection;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class PageController
{
    public function __construct(private Twig $twig, private Connection $connection)
    {
    }

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
            'url' => ''
        ];

        return $this->twig->render($response, 'pages/index.twig', $data);
    }
}
