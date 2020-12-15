<?php

namespace App\Test\TestCase\Action\User;

use App\Test\Traits\AppTestTrait;
use App\Test\Traits\DatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserCreateActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testAction(): void
    {
        $request = $this->createJsonRequest(
            'POST',
            '/api/users',
            ['username' => 'admin', 'email' => 'mail@example.com']
        );

        $response = $this->app->handle($request);

        $this->assertJsonData(['user_id' => 1], $response);
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame(201, $response->getStatusCode());

        $this->assertTableRowCount(1, 'users');

        $expected = [
            'id' => '1',
            'username' => 'admin',
            'password' => null,
            'email' => 'mail@example.com',
            'first_name' => null,
            'last_name' => null,
            'role' => null,
            'locale' => null,
            'enabled' => '0',
            'created_at' => '2020-01-01 00:00:00',
            'created_user_id' => null,
            'updated_at' => null,
            'updated_user_id' => null,
        ];

        $this->assertTableRow($expected, 'users', 1);
        $this->assertTableRowValue('1', 'users', 1, 'id');
    }
}
