<?php

namespace App\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use UnexpectedValueException;

/**
 * Request sensitive URL generator.
 */
final class UrlGenerator
{
    /**
     * @var RouteParserInterface
     */
    private $routeParser;

    /**
     * @var ServerRequestInterface|null
     */
    private $request;

    /**
     * The constructor.
     *
     * @param RouteParserInterface $routeParser The route parser
     * @param ServerRequestInterface|null $request The request
     */
    public function __construct(RouteParserInterface $routeParser, ServerRequestInterface $request = null)
    {
        $this->routeParser = $routeParser;
        $this->request = $request;
    }

    /**
     * Set request.
     *
     * @param ServerRequestInterface $request The request
     */
    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * Get the request.
     *
     * @throws UnexpectedValueException
     *
     * @return ServerRequestInterface The request
     */
    private function getRequest(): ServerRequestInterface
    {
        if (!$this->request) {
            throw new UnexpectedValueException('The request is not defined');
        }

        return $this->request;
    }

    /**
     * Build the path for a named route including the base path.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param string $routeName The route name
     * @param array<mixed> $data Named argument replacement data
     * @param array<mixed> $queryParams Optional query string parameters
     *
     * @return string The url
     */
    public function urlFor(
        string $routeName,
        array $data = [],
        array $queryParams = []
    ): string {
        return $this->routeParser->urlFor($routeName, $data, $queryParams);
    }

    /**
     * Build the path for a named route including the base path.
     *
     * This method prepares the response object to return an HTTP Redirect
     * response to the client.
     *
     * @param string $routeName The route name
     * @param array<mixed> $data Named argument replacement data
     * @param array<mixed> $queryParams Optional query string parameters
     *
     * @return string The url
     */
    public function fullUrlFor(
        string $routeName,
        array $data = [],
        array $queryParams = []
    ): string {
        return $this->routeParser->fullUrlFor(
            $this->getRequest()->getUri(),
            $routeName,
            $data,
            $queryParams
        );
    }
}
