<?php

// Define app routes

use Slim\App;

/** @var App $app */
$app->get('/', \App\Action\HomeIndexAction::class);

$app->get('/hello/{name}', \App\Action\HelloAction::class);

$app->post('/users', \App\Action\CreateUserAction::class);
