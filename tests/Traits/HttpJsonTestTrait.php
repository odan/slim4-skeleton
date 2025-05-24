<?php

namespace App\Test\Traits;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * HTTP JSON Test Trait.
 *
 * Requires: HttpTestTrait, ArrayTestTrait
 */
trait HttpJsonTestTrait
{
    /**
     * Create a JSON request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array|null $data The json data
     *
     * @return ServerRequestInterface
     */
    protected function createJsonRequest(
        string $method,
        string|UriInterface $uri,
        ?array $data = null
    ): ServerRequestInterface {
        $request = $this->createRequest($method, $uri);

        if ($data !== null) {
            $request->getBody()->write((string)json_encode($data));
        }

        return $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * Verify that the specified array is an exact match for the returned JSON.
     *
     * @param array $expected The expected array
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonData(array $expected, ResponseInterface $response): void
    {
        $data = $this->getJsonData($response);

        $this->assertSame($expected, $data);
    }

    /**
     * Get JSON response as array.
     *
     * @param ResponseInterface $response The response
     *
     * @return array The data
     */
    protected function getJsonData(ResponseInterface $response): array
    {
        $actual = (string)$response->getBody();
        $this->assertJson($actual);

        return (array)json_decode($actual, true);
    }

    /**
     * Verify JSON response.
     *
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonContentType(ResponseInterface $response): void
    {
        $this->assertStringContainsString('application/json', $response->getHeaderLine('Content-Type'));
    }

    /**
     * Verify that the specified array is an exact match for the returned JSON.
     *
     * @param mixed $expected The expected value
     * @param string $path The array path
     * @param ResponseInterface $response The response
     *
     * @return void
     */
    protected function assertJsonValue(mixed $expected, string $path, ResponseInterface $response): void
    {
        $this->assertSame($expected, $this->getArrayValue($this->getJsonData($response), $path));
    }
}
