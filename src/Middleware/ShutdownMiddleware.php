<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\ErrorHandler\ErrorHandler;

/**
 * Middleware.
 */
final class ShutdownMiddleware implements MiddlewareInterface
{
    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Throw an exception when a PHP error occurs
        // and handled it with the Slim error handler.
        ErrorHandler::register();

        return $handler->handle($request);
    }
}
