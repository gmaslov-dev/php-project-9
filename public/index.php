<?php

use DI\Container;
use Hexlet\Code\Initializer\ContainerInitializer;
use Hexlet\Code\Initializer\MiddlewareInitializer;
use Hexlet\Code\Initializer\RouteInitializer;
use Slim\Factory\AppFactory;
use Carbon\Carbon;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();
$app = AppFactory::createFromContainer($container);

Carbon::setLocale('ru');
date_default_timezone_set('Europe/Moscow');

ContainerInitializer::init($app);
MiddlewareInitializer::init($app);
RouteInitializer::init($app);

$app->run();
