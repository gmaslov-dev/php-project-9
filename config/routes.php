<?php

use Hexlet\Code\Controller\PageController;
use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (App $app) {
    $app->get('/', [PageController::class, 'index'])->setName('home');
};
