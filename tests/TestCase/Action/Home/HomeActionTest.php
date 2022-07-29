<?php

namespace App\Test\TestCase\Action\Home;

use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Home\HomeAction
 */
class HomeActionTest extends TestCase
{
    use AppTestTrait;

    public function testAction(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->app->handle($request);

        // Assert: Redirect
        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
    }

    public function testPageNotFound(): void
    {
        $request = $this->createRequest('GET', '/nada');
        $response = $this->app->handle($request);

        // Assert: Not found
        $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }
}
