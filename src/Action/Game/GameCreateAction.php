<?php

namespace App\Action\Game;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GameCreateAction extends GameAction
{
    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $args
    ): ResponseInterface
    {

        $player_id = (string)$args['player_id'];
        $id = $this->service->create($player_id);

        // Build the HTTP response
        return $this->renderer
            ->json($response, $id)
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
