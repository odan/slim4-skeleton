<?php

namespace App\Test\TestCase\Action\User;

use App\Domain\User\Type\UserRoleType;
use App\Test\Fixture\UserFixture;
use App\Test\Traits\AppTestTrait;
use Cake\Chronos\Chronos;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\User\UserUpdateAction
 */
class UserUpdateActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUpdateUser(): void
    {
        Chronos::setTestNow('2021-02-01 00:00:00');

        $this->insertFixtures([UserFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/users/1',
            [
                'username' => 'admin',
                'password' => '12345678',
                'email' => 'mail@example.com',
                'first_name' => 'Sally',
                'last_name' => 'Doe',
                'user_role_id' => UserRoleType::ROLE_USER,
                'locale' => 'de_DE',
                'enabled' => true,
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);

        // Check database
        $expected = [
            'id' => '1',
            'username' => 'admin',
            'email' => 'mail@example.com',
            'first_name' => 'Sally',
            'last_name' => 'Doe',
            'user_role_id' => '2',
            'locale' => 'de_DE',
            'enabled' => '1',
            'created_at' => '2019-01-09 14:05:19',
            'created_user_id' => '1',
            'updated_at' => '2021-02-01 00:00:00',
            'updated_user_id' => null,
        ];

        $this->assertTableRow($expected, 'users', 1, array_keys($expected));
        $this->assertTableRowValue('1', 'users', 1, 'id');

        // Password
        $password = $this->getTableRowById('users', 1)['password'];
        $this->assertStringStartsWith('$2y$10$', $password);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUserValidation(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/users/1',
            [
                'username' => '',
                'password' => '1234',
                'email' => 'mail',
                'user_role_id' => 99,
                'locale' => 'aa_aa',
                'enabled' => 1,
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'error' => [
                    'message' => 'Please check your input',
                    'code' => 422,
                    'details' => [
                        0 => [
                            'message' => 'Input required',
                            'field' => 'username',
                        ],
                        1 => [
                            'message' => 'Too short',
                            'field' => 'password',
                        ],
                        2 => [
                            'message' => 'Input required',
                            'field' => 'email',
                        ],
                        3 => [
                            'message' => 'Invalid',
                            'field' => 'user_role_id',
                        ],
                        4 => [
                            'message' => 'Invalid',
                            'field' => 'locale',
                        ],
                    ],
                ],
            ],
            $response
        );
    }
}
