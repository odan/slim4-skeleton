<?php

namespace App\Test\Traits;

use Psr\Http\Message\ServerRequestInterface;

/**
 * HTTP BasicAuth Test Trait.
 */
trait HttpBasicAuthTestTrait
{
    /**
     * Add BasicAuth to request.
     *
     * @param ServerRequestInterface $request The request
     *
     * @return ServerRequestInterface The request
     */
    protected function withHttpBasicAuth(ServerRequestInterface $request): ServerRequestInterface
    {
        return $request->withHeader('Authorization', 'Basic ' . base64_encode('api-user:secret'));
    }
}
