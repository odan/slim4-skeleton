<?php

namespace App\Middleware;

use App\Routing\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware.
 */
final class UrlGeneratorMiddleware implements MiddlewareInterface
{
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * The constructor.
     *
     * @param UrlGenerator $urlGenerator The url generator
     */
    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
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
        $this->urlGenerator->setRequest($request);

        return $handler->handle($request);
    }
}
