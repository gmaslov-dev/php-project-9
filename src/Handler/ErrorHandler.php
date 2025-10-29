<?php

namespace Hexlet\Code\Handler;

use Slim\Interfaces\ErrorHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Throwable;

readonly class ErrorHandler implements ErrorHandlerInterface
{
    public function __construct(
        private Twig $view
    ) {
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): Response {
        $response = new \Slim\Psr7\Response();

        if ($exception instanceof HttpNotFoundException) {
            // 404
            return $this->view->render($response->withStatus(404), 'errors/404.twig');
        }

        // 500 или другие ошибки
        return $this->view->render($response->withStatus(500), 'errors/500.twig');
    }
}
