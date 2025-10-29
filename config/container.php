<?php

use DI\Container;
use GuzzleHttp\Client;
use Hexlet\Code\Database\Connection;
use Hexlet\Code\Handler\ErrorHandler;
use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Repository\UrlRepository;
use Hexlet\Code\Service\CheckService;
use Hexlet\Code\Service\UrlCheckerService;
use Hexlet\Code\Service\UrlCheckService;
use Slim\Flash\Messages;

use Slim\Views\Twig;

$container = new Container();

$container->set(Twig::class, function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
});

$container->set(Connection::class, function () {
    return Connection::get();
});

$container->set(UrlRepository::class, function ($container) {
    return new UrlRepository($container->get(Connection::class)->connect());
});

$container->set(CheckRepository::class, function ($container) {
    return new CheckRepository($container->get(Connection::class)->connect());
});

$container->set(CheckService::class, function ($container) {
    return new CheckService($container->get(CheckRepository::class));
});

$container->set(UrlCheckService::class, function ($container) {
    return new UrlCheckService($container->get(UrlRepository::class), $container->get(CheckRepository::class));
});

$container->set(Client::class, function () {
    return new Client([
        'timeout' => 5,
        'verify' => true,
        'http_errors' => false,
        'allow_redirects' => true,
    ]);
});

$container->set(UrlCheckerService::class, function ($container) {
    return new UrlCheckerService($container->get(Client::class), $container->get(UrlRepository::class), $container->get(CheckRepository::class));
});

$container->set(Messages::class, fn() => new Messages());

$container->set(ErrorHandler::class, function ($container) {
    return new ErrorHandler($container->get(Twig::class));
});

return $container;
