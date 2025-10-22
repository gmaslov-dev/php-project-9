<?php

use Hexlet\Code\Controller\PageController;
use Hexlet\Code\Controller\UrlController;
use Slim\App;

return function (App $app) {
    $app->get('/', [PageController::class, 'index'])->setName('home');
    $app->get('/urls', [UrlController::class, 'index'])->setName('urls');
    $app->post('/urls', [UrlController::class, 'create'])->setName('urls.create');
};
