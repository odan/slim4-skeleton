<?php

namespace App\Test\TestCase\Action\Doc;

use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class SwaggerActionTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testVersion1(): void
    {
        $request = $this->createRequest('GET', '/docs/v1');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertStringContainsString('<div id="swagger-ui"></div>', (string)$response->getBody());
    }
}
