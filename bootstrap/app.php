<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Carbon\Carbon;

session_start();

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::createFromContainer($container);

Carbon::setLocale('ru');
date_default_timezone_set('Europe/Moscow');

(require __DIR__ . '/../config/middleware.php')($app);
(require __DIR__ . '/../config/routes.php')($app);

return $app;
