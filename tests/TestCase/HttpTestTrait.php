<?php

namespace App\Test\TestCase;

use App\Domain\User\Data\UserSessionData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use UnexpectedValueException;

/**
 * Acceptance Test.
 */
trait HttpTestTrait
{
    use DatabaseTestTrait;

    /**
     * Create a server request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array $serverParams The server parameters
     *
     * @return ServerRequestInterface
     */
    protected function createRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        // A phpunit fix #3026
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER = [
                'SCRIPT_NAME' => '/public/index.php',
                'REQUEST_TIME_FLOAT' => microtime(true),
                'REQUEST_TIME' => (int)microtime(true),
            ];
        }

        $factory = new ServerRequestFactory();

        return $factory->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * Add post data.
     *
     * @param ServerRequestInterface $request The request
     * @param mixed[] $data The data
     *
     * @return ServerRequestInterface
     */
    protected function withFormData(ServerRequestInterface $request, array $data): ServerRequestInterface
    {
        if (!empty($data)) {
            $request = $request->withParsedBody($data);
        }

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    /**
     * Add Json data.
     *
     * @param ServerRequestInterface $request The request
     * @param mixed[] $data The data
     *
     * @return ServerRequestInterface
     */
    protected function withJson(ServerRequestInterface $request, array $data): ServerRequestInterface
    {
        $request = $request->withParsedBody($data);

        return $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * Make request.
     *
     * @param ServerRequestInterface $request The request
     *
     * @return ResponseInterface
     */
    protected function request(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getApp()->handle($request);
    }

    /**
     * Login user.
     *
     * @return void
     */
    private function loginUser(): void
    {
        $user = new UserSessionData();
        $user->id = 1;
        $user->locale = 'en_US';
        $session = $this->getContainer()->get(Session::class);

        if ($session === null) {
            throw new UnexpectedValueException('Session not defined');
        }

        $session->set('user', $user);
    }
}
