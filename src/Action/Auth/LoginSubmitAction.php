<?php

namespace App\Action\Auth;

use App\Domain\User\Data\UserAuthData;
use App\Domain\User\Service\UserAuth;
use App\Responder\Responder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var SessionInterface
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
     * @param SessionInterface $session The session handler
     * @param UserAuth $auth The user auth
     */
    public function __construct(Responder $responder, SessionInterface $session, UserAuth $auth)
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

        $flash = $this->session->getFlash();
        $flash->clear();

        if ($user) {
            $this->startUserSession($user);
            $flash->add('success', __('Login successfully'));
            $routeName = 'user-list';
        } else {
            $flash->add('error', __('Login failed!'));
            $routeName = 'login';
        }

        return $this->responder->withRedirectFor($response, $routeName);
    }

    /**
     * Init user session.
     *
     * @param UserAuthData $user The user
     *
     * @return void
     */
    private function startUserSession(UserAuthData $user): void
    {
        // Clears all session data and regenerates session ID
        $this->session->destroy();
        $this->session->start();
        $this->session->regenerateId();

        $this->session->set('user', $user);

        // Store user settings in session
        $this->auth->setUser($user);
    }
}
