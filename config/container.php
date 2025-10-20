<?php

use DI\Container;
use Hexlet\Code\Database\Connection;
use Slim\Views\Twig;

$container = new Container();

$container->set(Twig::class, function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
});

$container->set(Connection::class, function () {
    return Connection::getInstance();
});

return $container;
