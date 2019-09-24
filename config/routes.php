<?php

// Define app routes

use Slim\App;

return static function (App $app) {
    /** @var App $app */
    $app->get('/', \App\Action\HomeIndexAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\HelloAction::class)->setName('hello');

    $app->get('/users', \App\Action\UserIndexAction::class)->setName('users-index');

    $app->post('/users', \App\Action\UserCreateAction::class)->setName('users');
};
