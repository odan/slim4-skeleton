<?php

namespace App\Middleware;

use App\Domain\User\Data\UserAuthData;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware.
 */
final class LocaleSessionMiddleware implements MiddlewareInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * Constructor.
     *
     * @param SessionInterface $session The session handler
     */
    public function __construct(SessionInterface $session)
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
        // Here you should read the user language from the session or other parameters

        /** @var UserAuthData|null $user */
        $user = $this->session->get('user');
        $locale = $user ? $user->locale : 'en_US';

        $request = $request->withAttribute('locale', $locale);

        return $handler->handle($request);
    }
}
