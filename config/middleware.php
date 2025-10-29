<?php

use Hexlet\Code\Handler\ErrorHandler;
use Slim\App;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $container = $app->getContainer();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($container?->get(ErrorHandler::class));

    $app->add(MethodOverrideMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
};
