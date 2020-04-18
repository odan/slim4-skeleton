<?php

namespace App\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteContext;
use UnexpectedValueException;

/**
 * Request sensitive URL generator.
 */
final class UrlGenerator
{
    /**
     * @var ServerRequestInterface|null
     */
    private $request;

    /**
     * The constructor.
     *
     * @param ServerRequestInterface|null $request The request
     */
    public function __construct(ServerRequestInterface $request = null)
    {
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
        return $this->getRouteParser()->urlFor($routeName, $data, $queryParams);
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
        return $this->getRouteParser()->fullUrlFor(
            $this->getRequest()->getUri(),
            $routeName,
            $data,
            $queryParams
        );
    }

    /**
     * Get route parser.
     *
     * @throws UnexpectedValueException
     *
     * @return RouteParserInterface The route parser
     */
    private function getRouteParser(): RouteParserInterface
    {
        if (!$this->request) {
            throw new UnexpectedValueException('The request is not defined');
        }

        return RouteContext::fromRequest($this->request)->getRouteParser();
    }
}
