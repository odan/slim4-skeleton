<?php

namespace App\Middleware;

use App\Domain\User\Data\UserAuthData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Middleware.
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

        /** @var UserAuthData|null $user */
        $user = $this->session->get('user');

        // Set locale from the session or use a default value
        // The TranslatorMiddleware changes the translation file
        $locale = $user ? $user->locale : 'en_US';
        $request = $request->withAttribute('locale', $locale);

        return $handler->handle($request);
    }
}
