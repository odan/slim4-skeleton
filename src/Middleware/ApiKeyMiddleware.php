<?php

namespace App\Middleware;

use App\Support\ApiKeyAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tuupola\Http\Factory\ResponseFactory;

class ApiKeyMiddleware implements MiddlewareInterface
{
    private ApiKeyAuth $apiKeyAuth;

    public function __construct(ApiKeyAuth $apiKeyAuth)
    {
        $this->apiKeyAuth = $apiKeyAuth;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = explode(' ', $request->getHeaderLine('Authorization'));
        $apikey = $authorization[1] ?? '';

        if (!$apikey || !$this->apiKeyAuth->validate($apikey)) {
            return (new ResponseFactory())
                ->createResponse(401)
                ->withHeader(
                    "Unauthorized",
                    "Unauthorized"
                );
        }

        return $handler->handle($request);
    }
}
