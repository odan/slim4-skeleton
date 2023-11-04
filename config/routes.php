<?php

// Define app routes

use App\Action\Auth\AuthAction;
use App\Action\Card\CardCreateAction;
use App\Action\Card\CardDeleteAction;
use App\Action\Card\CardFindAction;
use App\Action\Card\CardReadAction;
use App\Action\Card\CardUpdateAction;
use App\Action\Info\InfoFindOpponentAction;
use App\Action\Info\InfoFindSetAction;
use App\Action\Opponent\OpponentCreateAction;
use App\Action\Opponent\OpponentDeleteAction;
use App\Action\Opponent\OpponentFindAction;
use App\Action\Opponent\OpponentReadAction;
use App\Action\Opponent\OpponentUpdateAction;
use App\Action\Set\SetCreateAction;
use App\Action\Set\SetDeleteAction;
use App\Action\Set\SetFindAction;
use App\Action\Set\SetReadAction;
use App\Action\Set\SetUpdateAction;
use App\Action\Skills\SkillsCreateAction;
use App\Action\Skills\SkillsDeleteAction;
use App\Action\Skills\SkillsFindAction;
use App\Action\Skills\SkillsFindByOpponentAction;
use App\Action\Skills\SkillsReadAction;
use App\Action\Skills\SkillsUpdateAction;
use App\Action\Update\UpdateByDateAction;
use App\Middleware\JwtMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

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
            $app->get('/{id}/skills', SkillsFindByOpponentAction::class);
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

    // UPDATE
    $app->group(
        '/update',
        function (RouteCollectorProxy $app) {
            $app->get('/{date}', UpdateByDateAction::class);
            $app->get('/sets/{date}', SetFindAction::class);
            $app->get('/cards/{date}', CardFindAction::class);
            $app->get('/opponents/{date}', OpponentFindAction::class);
            $app->get('/skills/{date}', SkillsFindAction::class);
        }
    )->add(HttpBasicAuthentication::class);

    // ADMIN
    $app->group(
        '/backend',
        function (RouteCollectorProxy $app) {
            // SETS
            $app->group(
                '/sets',
                function (RouteCollectorProxy $app) {
                    $app->post('', SetCreateAction::class);
                    $app->put('/{id}', SetUpdateAction::class);
                    $app->delete('/{id}', SetDeleteAction::class);
                }
            );

            // CARDS
            $app->group(
                '/cards',
                function (RouteCollectorProxy $app) {
                    $app->post('', CardCreateAction::class);
                    $app->put('/{id}', CardUpdateAction::class);
                    $app->delete('/{id}', CardDeleteAction::class);
                }
            );

            // OPPONENTS
            $app->group(
                '/opponents',
                function (RouteCollectorProxy $app) {
                    $app->post('', OpponentCreateAction::class);
                    $app->put('/{id}', OpponentUpdateAction::class);
                    $app->delete('/{id}', OpponentDeleteAction::class);
                }
            );

            // SKILLS
            $app->group(
                '/skills',
                function (RouteCollectorProxy $app) {
                    $app->post('', SkillsCreateAction::class);
                    $app->put('/{id}', SkillsUpdateAction::class);
                    $app->delete('/{id}', SkillsDeleteAction::class);
                }
            );
        }
    )->add(JwtMiddleware::class);
};
