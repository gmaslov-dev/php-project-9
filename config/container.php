<?php

use DI\Container;
use Hexlet\Code\Database\Connection;
use Slim\Views\Twig;

$container = new Container();

$container->set(Twig::class, function () {
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
    return $twig;
});

$container->set(Connection::class, function () {
    $connection = Connection::getInstance();
    $sqlFile = __DIR__ . '/../database.sql';
    try {
        $pdo = $connection->getConnection();
        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);
    } catch (PDOException $e) {
        echo "Ошибка выполнения SQL: " . $e->getMessage();
    }

    return $connection;
});

return $container;
