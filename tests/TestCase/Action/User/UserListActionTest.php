<?php

namespace App\Test\TestCase\Action\User;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserListActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersWithoutLoginAction(): void
    {
        $request = $this->createRequest('GET', '/users');
        $response = $this->request($request);

        static::assertSame(302, $response->getStatusCode());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersWithLoginAction(): void
    {
        $this->loginUser();
        $request = $this->createRequest('GET', '/users');
        $response = $this->request($request);

        static::assertSame(200, $response->getStatusCode());
        static::assertStringContainsString('User list', (string)$response->getBody());
    }
}
