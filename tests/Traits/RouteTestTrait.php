<?php

namespace App\Test\Traits;

use Slim\App;

/**
 * Slim App Route Test Trait.
 */
trait RouteTestTrait
{
    /**
     * Build the path for a named route including the base path.
     *
     * @param string $routeName Route name
     * @param string[] $data Named argument replacement data
     * @param string[] $queryParams Optional query string parameters
     *
     * @return string route with base path
     */
    protected function urlFor(string $routeName, array $data = [], array $queryParams = []): string
    {
        return $this->app
            ->getRouteCollector()
            ->getRouteParser()
            ->urlFor($routeName, $data, $queryParams);
    }
}
