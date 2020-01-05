<?php

namespace App\Action\Hello;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

/**
 * Action.
 */
final class HelloAction
{
    /**
     * Action.
     *
     * @param ServerRequest $request The request
     * @param Response $response The response
     * @param array<string> $args The arguments
     *
     * @return Response The response
     */
    public function __invoke(ServerRequest $request, Response $response, array $args = []): Response
    {
        $name = $args['name'];

        $response->getBody()->write("Hello, $name");

        return $response;
    }
}
