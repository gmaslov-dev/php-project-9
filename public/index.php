<?php

use DI\Container;
use Hexlet\Code\Initializer\ContainerInitializer;
use Hexlet\Code\Initializer\MiddlewareInitializer;
use Hexlet\Code\Initializer\RouteInitializer;
use Slim\Factory\AppFactory;
use Carbon\Carbon;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

Carbon::setLocale('ru');
date_default_timezone_set('Europe/Moscow');

$container = ContainerInitializer::init();
$app = AppFactory::createFromContainer($container);

MiddlewareInitializer::init($app);
RouteInitializer::init($app);

$app->run();
