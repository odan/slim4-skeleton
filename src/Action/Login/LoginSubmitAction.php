<?php

namespace App\Action\Login;

use App\Domain\User\Data\UserAuthData;
use App\Domain\User\Service\UserAuth;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Routing\RouteContext;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class LoginSubmitAction
{
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
     * @param Session $session The session handler
     * @param UserAuth $auth The user auth
     */
    public function __construct(Session $session, UserAuth $auth)
    {
        $this->session = $session;
        $this->auth = $auth;
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
        $data = (array)$request->getParsedBody();
        $username = (string)($data['username'] ?? '');
        $password = (string)($data['password'] ?? '');

        $user = $this->auth->authenticate($username, $password);
        $router = RouteContext::fromRequest($request)->getRouteParser();

        $flash = $this->session->getFlashBag();
        $flash->clear();

        if ($user) {
            $this->startUserSession($user);
            $flash->set('success', __('Login successfully'));
            $url = $router->urlFor('user-list');
        } else {
            $flash->set('error', __('Login failed!'));
            $url = $router->urlFor('login');
        }

        return $response->withRedirect($url);
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
        $this->session->invalidate();
        $this->session->start();

        $this->session->set('user', $user);

        // Store user settings in session
        $this->auth->setUser($user);
    }
}
