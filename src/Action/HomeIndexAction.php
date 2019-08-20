<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class HomeIndexAction
{
    /**
     * Action.
     *
     * @param Request $request The request
     * @param Response $response The response
     * @param array $args The arguments
     *
     * @return Response The new response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $response->getBody()->write('Hello, World!');

        return $response;
    }
}
