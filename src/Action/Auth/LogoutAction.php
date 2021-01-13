<?php

namespace App\Action\Auth;

use App\Responder\Responder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class LogoutAction
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param SessionInterface $session The session handler
     * @param Responder $responder The responder
     */
    public function __construct(SessionInterface $session, Responder $responder)
    {
        $this->session = $session;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Logout user
        $this->session->destroy();

        return $this->responder->withRedirect($response, 'login');
    }
}
