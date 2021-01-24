<?php

namespace App\Test\TestCase\Action\User;

use App\Test\Fixture\UserFixture;
use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\User\UserDeleteAction
 */
class UserDeleteActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createJsonRequest('DELETE', '/api/users/1');
        $request = $this->withHttpBasicAuth($request);

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());

        // Check database
        $this->assertTableRowCount(1, 'users');
        $this->assertTableRowNotExists('users', 1);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testDeleteInvalidUser(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createJsonRequest('DELETE', '/api/users/99');
        $request = $this->withHttpBasicAuth($request);

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
