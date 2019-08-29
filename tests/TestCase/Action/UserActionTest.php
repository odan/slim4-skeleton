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
        $request = $this->withJson($request, ['username' => 'user', 'password' => 'secret']);
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame('{"result":{"success":true}}', (string)$response->getBody());
    }
}
