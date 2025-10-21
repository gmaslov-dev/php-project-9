<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\UrlRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class UrlController
{
    public function __construct(
        protected Twig $view,
        protected UrlRepository $urlRepository
    ) {}

    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'urls/index.twig', [
            'urls' => $this->urlRepository->getAll(),
        ]);
    }
}
