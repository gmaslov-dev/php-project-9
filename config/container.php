<?php

use DI\Container;
use Hexlet\Code\Database\Connection;
use Hexlet\Code\Repository\UrlRepository;
use Slim\Flash\Messages;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteParser;
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

$container->set(Slim\Flash\Messages::class, fn() => new Messages());

return $container;
