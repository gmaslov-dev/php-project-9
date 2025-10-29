<?php

namespace Hexlet\Code\Initializer;

use DI\Container;
use Hexlet\Code\Handler\ErrorHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

readonly class MiddlewareInitializer
{
    /**
     * @param App<Container> $app
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function init(App $app): void
    {
        $container = $app->getContainer();

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setDefaultErrorHandler($container->get(ErrorHandler::class));

        $app->add(MethodOverrideMiddleware::class);
        $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
    }
}
