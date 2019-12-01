<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\Hello\HelloAction::class)->setName('hello');

    $app->get('/users', \App\Action\User\UserListAction::class)->setName('user-list');

    $app->post('/users/datatable', \App\Action\User\UserListDataTableAction::class)->setName('user-datatable');

    $app->post('/api/users', \App\Action\User\UserCreateAction::class)->setName('api-user-create');
};
