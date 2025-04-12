<?php

// Define app routes

use App\Action\AvailableSet\AvailableSetFindAction;
use App\Action\Card\CardFindAction;
use App\Action\Game\GameCreateAction;
use App\Action\Game\GameDeleteAction;
use App\Action\Game\GameFindAction;
use App\Action\Home\HomeAction;
use App\Action\Home\PingAction;
use App\Action\Opponent\OpponentFindAction;
use App\Action\Remove\RemovalsByDateAction;
use App\Action\Review\ReviewCardAction;
use App\Action\Set\SetFindAction;
use App\Action\Skills\SkillsFindAction;
use App\Action\Update\UpdateByDateAction;
use App\Action\VirtualCard\VirtualCardFindAction;
use App\Action\VirtualSet\VirtualSetFindAction;
use App\Middleware\ApiKeyMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/ping', PingAction::class);
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
            $app->get('/virtual_sets/{date}', VirtualSetFindAction::class);
            $app->get('/available_sets/{date}', AvailableSetFindAction::class);
            $app->get('/virtual_cards/{date}', VirtualCardFindAction::class);
            $app->get('/playing_cards/{date}', CardFindAction::class); // ???
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
            $app->put('/cards', ReviewCardAction::class);
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
