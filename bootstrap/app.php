<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

session_start();

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::createFromContainer($container);

(require __DIR__ . '/../config/middleware.php')($app);
(require __DIR__ . '/../config/routes.php')($app);

return $app;
