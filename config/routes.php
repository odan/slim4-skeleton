<?php

// Define app routes

use Slim\App;

return static function (App $app) {
    /** @var App $app */
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\Hello\HelloAction::class)->setName('hello');

    $app->get('/users', \App\Action\User\ListUserAction::class)->setName('list-user');

    $app->post('/users', \App\Action\User\CreateUserAction::class)->setName('create-user');
};
