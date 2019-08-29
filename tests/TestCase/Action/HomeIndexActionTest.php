<?php

namespace App\Test\TestCase\Action;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class HomeIndexActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testIndexAction(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Hello, World', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testHelloAction(): void
    {
        $request = $this->createRequest('GET', '/hello/john');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Hello, john', (string)$response->getBody());
    }

    /**
     * Test invalid link.
     *
     * @return void
     */
    public function testPageNotFound(): void
    {
        $request = $this->createRequest('GET', '/not-existing-page');
        $response = $this->request($request);

        // Assert: Not found
        $this->assertSame(404, $response->getStatusCode());
    }
}
