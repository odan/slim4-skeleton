<?php

namespace App\Utility;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use UnexpectedValueException;

/**
 * Redirect response helper.
 */
final class Redirector
{
    /**
     * Creates a redirect for the given url / route name.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param string $destination The redirect destination (url or route name)
     * @param array<mixed> $data Named argument replacement data
     * @param array<mixed> $queryParams Optional query string parameters
     *
     * @return ResponseInterface The response
     */
    public static function redirect(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $destination,
        array $data = [],
        array $queryParams = []
    ): ResponseInterface {
        if (!filter_var($destination, FILTER_VALIDATE_URL)) {
            $destination = RouteContext::fromRequest($request)
                ->getRouteParser()
                ->urlFor($destination, $data, $queryParams);
        }

        return $response->withStatus(302)->withHeader('Location', $destination);
    }
}
