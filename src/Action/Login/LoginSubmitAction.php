<?php

namespace App\Action\Login;

use App\Domain\User\Data\UserAuthData;
use App\Domain\User\Service\UserAuth;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Routing\RouteContext;

/**
 * Action.
 */
final class LoginSubmitAction
{
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
     * @param SessionInterface $session The session handler
     * @param UserAuth $auth The user auth
     */
    public function __construct(SessionInterface $session, UserAuth $auth)
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

        if ($user) {
            $this->startUserSession($user);
            $url = $router->urlFor('user-list');
        } else {
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
        // Clear session data
        $this->session->destroy();
        $this->session->start();

        // Create new session id
        $this->session->regenerateId();

        $this->session->set('user', $user);

        // Store user settings in session
        $this->auth->setUser($user);
    }
}
