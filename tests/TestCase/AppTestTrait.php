<?php

namespace App\Test\TestCase;

use DI\Container;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UnexpectedValueException;

/**
 * Container Trait.
 */
trait AppTestTrait
{
    /** @var Container */
    protected $container;

    /** @var App */
    protected $app;

    /**
     * Clear session.
     *
     * @after
     *
     * @return void
     */
    protected function destroySession(): void
    {
        $session = $this->container->get(SessionInterface::class);
        if (!$session->isStarted()) {
            $session->start();
        }
        $session->invalidate();
    }

    /**
     * Bootstrap app.
     *
     * @before
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function setupContainer(): void
    {
        $this->app = require __DIR__ . '/../../config/bootstrap.php';

        $container = $this->app->getContainer();
        if ($container === null) {
            throw new UnexpectedValueException('Container must be initialized');
        }

        $this->container = $container;
    }

    /**
     * Add mock to container.
     *
     * @param string $class The class or interface
     *
     * @return MockObject The mock
     */
    protected function mock(string $class): MockObject
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class not found: %s', $class));
        }

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->container->set($class, $mock);

        return $mock;
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
        return (new ServerRequestFactory())->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * Create a JSON request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array|null $data The json data
     *
     * @return ServerRequestInterface
     */
    protected function createJsonRequest(string $method, $uri, array $data = null): ServerRequestInterface
    {
        $request = $this->createRequest($method, $uri);

        if ($data !== null) {
            $request = $request->withParsedBody($data);
        }

        return $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * Create a form request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array|null $data The form data
     *
     * @return ServerRequestInterface
     */
    protected function createFormRequest(string $method, $uri, array $data = null): ServerRequestInterface
    {
        $request = $this->createRequest($method, $uri);

        if ($data !== null) {
            $request = $request->withParsedBody($data);
        }

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    /**
     * Verify that the specified array is an exact match for the returned JSON.
     *
     * @param ResponseInterface $response The response
     * @param array $expected The expected array
     *
     * @return void
     */
    protected function assertJsonData(ResponseInterface $response, array $expected): void
    {
        $actual = (string)$response->getBody();
        $this->assertJson($actual);
        $this->assertSame($expected, (array)json_decode($actual, true));
    }
}
