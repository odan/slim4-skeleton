<?php

namespace App\Test\Traits;

use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\HttpBasicAuthentication;

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
        $settings = [
            // Allow http for testing
            'secure' => false,
            'users' => [
                'api-user' => 'secret',
            ],
        ];

        $this->container->set(HttpBasicAuthentication::class, new HttpBasicAuthentication($settings));

        return $request->withHeader('Authorization', 'Basic ' . base64_encode('api-user:secret'));
    }
}
