<?php

namespace App\Test\TestCase\Action\User;

use App\Test\DatabaseTestTrait;
use App\Test\Fixture\UserFixture;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserViewActionTest extends TestCase
{
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testWithValidIdAction(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createRequest('GET', '/users/1');
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('User-ID:', (string)$response->getBody());
        $this->assertStringContainsString('<label>1</label>', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testWithValidId(): void
    {
        $request = $this->createRequest('GET', '/users/99');
        $response = $this->app->handle($request);

        $this->assertSame(400, $response->getStatusCode());
    }
}
