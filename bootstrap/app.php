<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/../config/routes.php')($app);

return $app;
