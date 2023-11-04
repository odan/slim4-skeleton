<?php

namespace App\Action\Opponent;

use App\Domain\Opponent\Service\OpponentFinderService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class OpponentFindAction
{
    protected OpponentFinderService $service;

    protected JsonRenderer $renderer;

    /**
     * @param OpponentFinderService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(OpponentFinderService $service, JsonRenderer $jsonRenderer)
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
        ResponseInterface      $response,
        array                  $args
    ): ResponseInterface
    {
        // Fetch parameters from the request
        if (array_key_exists("date", $args)) {
            $date = (int)$args["date"];
            $data = $this->service->findByDate($date);
        } else {
            $data = $this->service->find();
        }

        return $this->transform($response, $data);
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

        return $this->renderer->json(
            $response,
            [
                'data' => $list,
            ]
        );
    }
}
