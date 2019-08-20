<?php

namespace App\Test\TestCase\Action;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class TimeActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testTimeAction(): void
    {
        $request = $this->createServerRequest('GET', '/time');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Current time', (string)$response->getBody());
    }
}
