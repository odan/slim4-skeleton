<?php

// Define app routes

use App\Middleware\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('root');

    $app->get('/hello/{name}', \App\Action\Hello\HelloAction::class)->setName('hello');

    // HTML view
    $app->get('/users/{id}', \App\Action\User\UserViewAction::class)->setName('user-view');

    // API endpint
    $app->post('/api/users', \App\Action\User\UserCreateAction::class)->setName('api-user-create');

    $app->get('/login', \App\Action\Login\LoginAction::class)->setName('login');
    $app->post('/login', \App\Action\Login\LoginSubmitAction::class);
    $app->get('/logout', \App\Action\Login\LogoutAction::class)->setName('logout');

    // Password protected area
    $app->group('/users', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\User\UserListAction::class)->setName('user-list');
        $group->post('/datatable', \App\Action\User\UserListDataTableAction::class)->setName('user-datatable');
    })->add(UserAuthMiddleware::class);
};
