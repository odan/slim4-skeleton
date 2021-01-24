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
 * @coversDefaultClass \App\Action\User\UserFindAction
 */
class UserFindActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testListUsers(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createRequest('GET', '/api/users');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonData(
            [
                'users' => [
                    0 => [
                        'id' => '1',
                        'username' => 'admin',
                        'first_name' => null,
                        'last_name' => null,
                        'email' => 'admin@example.com',
                        'user_role_id' => '1',
                        'locale' => 'en_US',
                        'enabled' => '1',
                    ],
                    1 => [
                        'id' => '2',
                        'username' => 'user',
                        'first_name' => null,
                        'last_name' => null,
                        'email' => 'user@example.com',
                        'user_role_id' => '2',
                        'locale' => 'de_DE',
                        'enabled' => '1',
                    ],
                ],
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testListUsersWithoutLogin(): void
    {
        $request = $this->createRequest('GET', '/api/users');
        $request = $this->withHttpBasicAuth($request)->withoutHeader('Authorization');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_UNAUTHORIZED, $response->getStatusCode());
    }
}
