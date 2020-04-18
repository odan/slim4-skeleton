<?php

namespace App\Action\Login;

use App\Domain\User\Data\UserSessionData;
use App\Domain\User\Service\UserAuth;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class LoginSubmitAction
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserAuth
     */
    private $auth;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param Session $session The session handler
     * @param UserAuth $auth The user auth
     */
    public function __construct(Responder $responder, Session $session, UserAuth $auth)
    {
        $this->responder = $responder;
        $this->session = $session;
        $this->auth = $auth;
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
        $data = (array)$request->getParsedBody();
        $username = (string)($data['username'] ?? '');
        $password = (string)($data['password'] ?? '');

        $user = $this->auth->authenticate($username, $password);

        $flash = $this->session->getFlashBag();
        $flash->clear();

        if ($user) {
            $this->startUserSession($user);
            $flash->set('success', __('Login successfully'));
            $url = 'user-list';
        } else {
            $flash->set('error', __('Login failed!'));
            $url = 'login';
        }

        return $this->responder->redirect($response, $url);
    }

    /**
     * Init user session.
     *
     * @param UserSessionData $user The user
     *
     * @return void
     */
    private function startUserSession(UserSessionData $user): void
    {
        // Clears all session data and regenerates session ID
        $this->session->invalidate();
        $this->session->start();

        $this->session->set('user', $user);

        // Store user settings in session
        $this->auth->setUser($user);
    }
}
