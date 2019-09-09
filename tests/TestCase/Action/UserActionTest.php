<?php

namespace App\Test\TestCase\Action;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAddUser(): void
    {
        $request = $this->createRequest('POST', '/users');
        $request = $this->withJson($request, ['key1' => 'value1', 'key2' => 'value2']);
        $response = $this->request($request);

        static::assertSame(200, $response->getStatusCode());
        static::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        static::assertSame('{"key1":"value1","key2":"value2"}', (string)$response->getBody());
    }
}
