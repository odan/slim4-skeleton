<?php

namespace App\Test\TestCase\Action\Home;

use App\Test\AppTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class HomeActionTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAction(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->request($request);

        static::assertStringContainsString('Hello, World', (string)$response->getBody());
        static::assertSame(200, $response->getStatusCode());
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
        static::assertSame(404, $response->getStatusCode());
    }
}
