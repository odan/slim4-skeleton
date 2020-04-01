<?php

namespace App\Action\Login;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @var Session
     */
    private $session;

    /**
     * The constructor.
     *
     * @param Twig $twig The twig engine
     * @param Session $session The session handler
     */
    public function __construct(Twig $twig, Session $session)
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
        // Logout user
        $this->session->remove('user');

        return $this->twig->render($response, 'login/login.twig');
    }
}
