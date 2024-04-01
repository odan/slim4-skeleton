<?php

namespace App\Action\Remove;

use App\Domain\Remove\Service\RemovalFinderService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class RemovalsByDateAction
{
    private RemovalFinderService $service;

    private JsonRenderer $renderer;

    /**
     * The constructor.
     *
     * @param RemovalFinderService $service The service
     * @param JsonRenderer $renderer The responder
     */
    public function __construct(RemovalFinderService $service, JsonRenderer $renderer)
    {
        $this->service = $service;
        $this->renderer = $renderer;
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
        // Fetch parameters from the request
        $date = (int)$args['date'];

        // Invoke the domain (service class)
        $items = $this->service->findByDate($date);
        // Transform result
        return $this->renderer->json($response, $items);
    }
}
