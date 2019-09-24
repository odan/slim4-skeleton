<?php

namespace App\Test\TestCase\Action\User;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class CreateUserActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAction(): void
    {
        $request = $this->createRequest('POST', '/users');
        $request = $this->withJson($request, ['username' => 'admin', 'email' => 'mail@example.com']);
        $response = $this->request($request);

        static::assertSame('{"success":true,"user_id":1}', (string)$response->getBody());
        static::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        static::assertSame(200, $response->getStatusCode());
    }
}
