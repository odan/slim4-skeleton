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

        static::assertSame('{"user_id":1}', (string)$response->getBody());
        static::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        static::assertSame(201, $response->getStatusCode());
    }
}
