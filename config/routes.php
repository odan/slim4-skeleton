<?php

// Define app routes

use Slim\App;

return static function (App $app) {
    /** @var App $app */
    $app->get('/', \App\Action\HomeIndexAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\HelloAction::class);

    $app->post('/users', \App\Action\CreateUserAction::class);

    $app->get('/time', \App\Action\TimeAction::class);
};
