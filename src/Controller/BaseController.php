<?php

namespace Hexlet\Code\Controller;

use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BaseController
{
    public function __construct(
        protected Twig $view,
        protected Messages $flash,
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render(Response $response, string $template, array $data = []): Response
    {
        return $this->view->render($response, $template, $data);
    }

    protected function addFlash(string $type, string $message): void
    {
        $this->flash->addMessage($type, $message);
    }

    protected function getFlash(): array
    {
        return $this->flash->getMessages();
    }

    protected function getRouteParser(Request $request): \Slim\Interfaces\RouteParserInterface
    {
        return RouteContext::fromRequest($request)->getRouteParser();
    }
}
