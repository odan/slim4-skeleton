<?php

namespace App\Test\TestCase\Action\User;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserCreateActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAction(): void
    {
        $request = $this->createRequest('POST', '/api/users');
        $request = $this->withJson($request, ['username' => 'admin', 'email' => 'mail@example.com']);
        $response = $this->request($request);

        static::assertSame('{"user_id":1}', (string)$response->getBody());
        static::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        static::assertSame(200, $response->getStatusCode());
    }
}
