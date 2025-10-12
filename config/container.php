<?php

use DI\Container;
use Slim\Views\Twig;

$container = new Container();

$container->set(Twig::class, function () {
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
    return $twig;
});

return $container;
