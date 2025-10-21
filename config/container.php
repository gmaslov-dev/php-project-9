<?php

use DI\Container;
use Hexlet\Code\Database\Connection;
use Hexlet\Code\Repository\UrlRepository;
use Slim\Views\Twig;
use PDO;

$container = new Container();

$container->set(Twig::class, function () {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
});

$container->set(PDO::class, function () {
    return Connection::get()->connect();
});

$container->set(UrlRepository::class, function ($container) {
    return new UrlRepository($container->get(PDO::class));
});

return $container;
