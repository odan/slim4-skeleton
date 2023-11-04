<?php

namespace App\Action\Skills;

use App\Domain\Skills\Service\SkillsFinderService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SkillsFindByOpponentAction
{
    protected SkillsFinderService $service;

    protected JsonRenderer $renderer;

    /**
     * @param SkillsFinderService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(SkillsFinderService $service, JsonRenderer $jsonRenderer)
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
        $opponent = (int)$args['id'];

        // Invoke the domain (service class)
        $items = (array)$this->service->findSkillsByOpponent($opponent);

        // Transform result
        return $this->transform($response, $items);
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