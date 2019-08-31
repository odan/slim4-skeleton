<?php

namespace App\Test\TestCase;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * Acceptance Test.
 */
trait HttpTestTrait
{
    use ContainerTestTrait;

    /** {@inheritdoc} */
    protected function setUp(): void
    {
        $this->bootApp();
    }

    /** {@inheritdoc} */
    protected function tearDown(): void
    {
        $this->shutdownApp();
    }

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
                'REQUEST_TIME_FLOAT' => microtime(true),
                'REQUEST_TIME' => microtime(),
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
        $request = $request->withHeader('Content-Type', 'application/json');

        return $request;
    }

    /**
     * Make request.
     *
     * @param ServerRequestInterface $request The request
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    protected function request(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getApp()->handle($request);
    }
}
