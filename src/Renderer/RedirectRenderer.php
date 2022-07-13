<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouteParserInterface;

use function http_build_query;

/**
 * A redirect response renderer.
 */
final class RedirectRenderer
{
    private RouteParserInterface $routeParser;

    /**
     * The constructor.
     *
     * @param RouteParserInterface $routeParser The route parser
     */
    public function __construct(RouteParserInterface $routeParser)
    {
        $this->routeParser = $routeParser;
    }

    /**
     * Creates a redirect for the given url / route name.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param string $destination The redirect destination (url or route name)
     * @param array $queryParams Optional query string parameters
     *
     * @return ResponseInterface The response
     */
    public function redirect(
        ResponseInterface $response,
        string $destination,
        array $queryParams = []
    ): ResponseInterface {
        if ($queryParams) {
            $destination = sprintf('%s?%s', $destination, http_build_query($queryParams));
        }

        return $response->withStatus(302)->withHeader('Location', $destination);
    }

    /**
     * Creates a redirect for the given url / route name.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param string $routeName The redirect route name
     * @param array $data Named argument replacement data
     * @param array $queryParams Optional query string parameters
     *
     * @return ResponseInterface The response
     */
    public function redirectFor(
        ResponseInterface $response,
        string $routeName,
        array $data = [],
        array $queryParams = []
    ): ResponseInterface {
        return $this->redirect($response, $this->routeParser->urlFor($routeName, $data, $queryParams));
    }
}
