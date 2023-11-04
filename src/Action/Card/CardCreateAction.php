<?php

namespace App\Action\Card;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CardCreateAction extends CardAction
{
    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $id = $this->service->create($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['id' => $id])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
