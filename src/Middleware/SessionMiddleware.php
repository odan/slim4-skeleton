<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Session Middleware.
 */
final class SessionMiddleware implements MiddlewareInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * The constructor.
     *
     * @param Session $session The session handler
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

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
        $this->session->start();

        return $handler->handle($request);
    }
}
