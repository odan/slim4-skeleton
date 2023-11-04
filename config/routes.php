<?php

// Define app routes

use App\Action\Auth\AuthAction;
use App\Action\Info\InfoFindOpponentAction;
use App\Action\Info\InfoFindSetAction;
use App\Action\Set\SetCreateAction;
use App\Action\Set\SetDeleteAction;
use App\Action\Set\SetFindAction;
use App\Action\Set\SetReadAction;
use App\Action\Set\SetUpdateAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);
            $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);
            $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
            $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
            $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);
        }
    );

    // AUTH
    $app->post('/auth', AuthAction::class);
    /*
    $app->group(
        '/auth',
        function (RouteCollectorProxy $app) {
            $app->post('', AuthAction::class);
        }
    );
    */


    // INFO
    $app->group(
        '/info',
        function (RouteCollectorProxy $app) {
            $app->get('/sets', InfoFindSetAction::class);
            $app->get('/opponents', InfoFindOpponentAction::class);
        });

    // SETS
    $app->group(
        '/sets',
        function (RouteCollectorProxy $app) {
            $app->get('', SetFindAction::class);
            $app->get('/{id}', SetReadAction::class);
            $app->post('', SetCreateAction::class);
            $app->put('/{id}', SetUpdateAction::class);
            $app->delete('/{uid}', SetDeleteAction::class);
        }
    )->add(HttpBasicAuthentication::class);
};
