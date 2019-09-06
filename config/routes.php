<?php

// Define app routes

use Slim\App;

return static function (App $app) {
    /** @var App $app */
    $app->get('/', \App\Action\HomeIndexAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\HelloAction::class)->setName('hello');

    $app->post('/users', \App\Action\CreateUserAction::class)->setName('users');

    $app->get('/time', \App\Action\TimeAction::class)->setName('time');
};
