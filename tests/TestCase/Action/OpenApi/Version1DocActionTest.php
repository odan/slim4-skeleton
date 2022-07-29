<?php

namespace App\Test\TestCase\Action\OpenApi;

use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\OpenApi\Version1DocAction
 */
class Version1DocActionTest extends TestCase
{
    use AppTestTrait;

    public function testAction(): void
    {
        $request = $this->createRequest('GET', '/docs/v1');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertStringContainsString('<div id="swagger-ui"></div>', (string)$response->getBody());
    }
}
