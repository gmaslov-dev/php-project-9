<?php

use Hexlet\Code\Controller\PageController;
use Hexlet\Code\Controller\UrlController;
use Slim\App;

return function (App $app) {
    // pages
    $app->get('/', [PageController::class, 'index'])->setName('home');
    // urls
    $app->get('/urls', [UrlController::class, 'index'])->setName('urls');
    $app->post('/urls', [UrlController::class, 'create'])->setName('urls.create');
    $app->get('/urls/{id}', [UrlController::class, 'show'])->setName('urls.show');
    // checks
    $app->post('urls/{url_id}/checks', [CheckController::class, 'create'])->setName('checks.create');
};
