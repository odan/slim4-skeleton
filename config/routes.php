<?php

// Define app routes

use App\Action\Auth\AuthAction;
use App\Action\Card\CardFindAction;
use App\Action\Card\CardReadAction;
use App\Action\Info\InfoFindOpponentAction;
use App\Action\Info\InfoFindSetAction;
use App\Action\Opponent\OpponentFindAction;
use App\Action\Opponent\OpponentReadAction;
use App\Action\Set\SetFindAction;
use App\Action\Set\SetReadAction;
use App\Action\Skills\SkillsFindAction;
use App\Action\Skills\SkillsReadAction;
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
        }
    )->add(HttpBasicAuthentication::class);

    // OPPONENTS
    $app->group(
        '/opponents',
        function (RouteCollectorProxy $app) {
            $app->get('', OpponentFindAction::class);
            $app->get('/{id}', OpponentReadAction::class);
            //$app->get('/{id}/skills', SkillsFindByOpponentAction::class);
        }
    )->add(HttpBasicAuthentication::class);

    // SKILLS
    $app->group(
        '/skills',
        function (RouteCollectorProxy $app) {
            $app->get('', SkillsFindAction::class);
            $app->get('/{id}', SkillsReadAction::class);
        }
    )->add(HttpBasicAuthentication::class);

    // CARDS
    $app->group(
        '/cards',
        function (RouteCollectorProxy $app) {
            $app->get('', CardFindAction::class);
            $app->get('/{id}', CardReadAction::class);
        }
    )->add(HttpBasicAuthentication::class);
};
