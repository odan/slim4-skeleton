<?php

// Define app routes

use App\Action\Card\CardCreateAction;
use App\Action\Card\CardFindAction;
use App\Action\Game\GameCreateAction;
use App\Action\Game\GameDeleteAction;
use App\Action\Game\GameFindAction;
use App\Action\Home\HomeAction;
use App\Action\Mistake\MistakeFindAction;
use App\Action\Opponent\OpponentFindAction;
use App\Action\Remove\RemovalsByDateAction;
use App\Action\Set\SetFindAction;
use App\Action\Skills\SkillsFindAction;
use App\Action\Update\UpdateByDateAction;
use App\Action\VirtualSet\VirtualSetFindAction;
use App\Middleware\ApiKeyMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', HomeAction::class);

    // UPDATE
    $app->group(
        '/update',
        function (RouteCollectorProxy $app) {
            $app->get('/{date}', UpdateByDateAction::class);
            $app->get('/sets/{date}', SetFindAction::class);
            $app->get('/cards/{date}', CardFindAction::class);
            $app->get('/opponents/{date}', OpponentFindAction::class);
            $app->get('/skills/{date}', SkillsFindAction::class);
            $app->get('/mistakes/{date}', MistakeFindAction::class);
            $app->get('/virtual_sets/{date}', VirtualSetFindAction::class);
        }
    )->add(ApiKeyMiddleware::class);

    // REMOVE
    $app->group(
        '/removal',
        function (RouteCollectorProxy $app) {
            $app->get('/{date}', RemovalsByDateAction::class);
        }
    )->add(ApiKeyMiddleware::class);

    // REVIEW
    $app->group(
        '/review',
        function (RouteCollectorProxy $app) {
            $app->put('/cards', CardCreateAction::class);
        }
    )->add(ApiKeyMiddleware::class);

    // GAMES
    $app->group(
        '/game',
        function (RouteCollectorProxy $app) {
            $app->put('/{player_id}', GameCreateAction::class);
            $app->get('/verify/{game_id}', GameFindAction::class);
            $app->get('/expired', GameFindAction::class);
            $app->delete('/{game_id}', GameDeleteAction::class);
        }
    )->add(ApiKeyMiddleware::class);
};
