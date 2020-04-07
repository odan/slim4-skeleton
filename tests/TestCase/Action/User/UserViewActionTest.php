<?php

namespace App\Test\TestCase\Action\User;

use App\Test\Fixture\UserFixture;
use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserViewActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testWithValidIdAction(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createRequest('GET', '/users/1');
        $response = $this->request($request);

        static::assertSame(200, $response->getStatusCode());
        static::assertStringContainsString('User-ID:', (string)$response->getBody());
        static::assertStringContainsString('<label>1</label>', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testWithValidId(): void
    {
        $request = $this->createRequest('GET', '/users/99');
        $response = $this->request($request);

        static::assertSame(400, $response->getStatusCode());
    }
}
