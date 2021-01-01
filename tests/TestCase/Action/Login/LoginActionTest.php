<?php

namespace App\Test\TestCase\Action\Login;

use App\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class LoginActionTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testLoginAction(): void
    {
        $request = $this->createRequest('GET', '/login');
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());

        $body = (string)$response->getBody();
        $this->assertStringContainsString('<input type="text" id="username" name="username"', $body);
        $this->assertStringContainsString('<input type="password" id="password" name="password"', $body);
        $this->assertStringContainsString('<button id="login-button"', $body);
    }
}
