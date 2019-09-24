<?php

namespace App\Action\Hello;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class HelloAction
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
        $name = $args['name'];

        $response->getBody()->write("Hello, $name");

        return $response;
    }
}
