<?php

namespace App\Test\TestCase\Action\User;

use App\Test\DatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserCreateActionTest extends TestCase
{
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

        $this->assertJsonData($response, ['user_id' => 1]);
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame(201, $response->getStatusCode());
    }
}
