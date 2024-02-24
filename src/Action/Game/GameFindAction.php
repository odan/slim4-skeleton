<?php

namespace App\Action\Game;

use App\Domain\Game\Service\GameFinderService;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GameFindAction
{
    protected GameFinderService $service;

    protected JsonRenderer $renderer;

    /**
     * @param GameFinderService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(GameFinderService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }

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
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        if (array_key_exists("game_id", $args)) {
            $game_id = (int)$args["game_id"];
            $data = $this->service->findById($game_id);
            if (!empty($data)) {
                return $this->renderer->json($response, $data);
            } else {
                return $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
            }
        } else {
            $date = date("Ymd");
            $data = $this->service->findExpired($date);
            return $this->transform($response, $data);
        }
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $data The data
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $data): ResponseInterface
    {
        $list = [];

        foreach ($data as $item) {
            $list[] = (array)$item;
        }

        return $this->renderer->json($response, $list);
    }
}
