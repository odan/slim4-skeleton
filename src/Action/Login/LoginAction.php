<?php

namespace App\Action\Login;

use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;

/**
 * Action.
 */
final class LoginAction
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * The constructor.
     *
     * @param Twig $twig The twig engine
     * @param SessionInterface $session The session handler
     */
    public function __construct(Twig $twig, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    /**
     * Action.
     *
     * @param ServerRequest $request The request
     * @param Response $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        // Clears all session data and regenerates session ID
        $this->session->remove('user');

        if ($this->session->isStarted()) {
            $this->session->destroy();
        }

        return $this->twig->render($response, 'login/login.twig');
    }
}
