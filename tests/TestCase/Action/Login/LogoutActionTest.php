<?php

namespace App\Test\TestCase\Action\Login;

use App\Domain\User\Data\UserAuthData;
use App\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class LogoutActionTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testLogoutAction(): void
    {
        $session = $this->getSession();

        $user = new UserAuthData();
        $user->id = 1;
        $user->locale = 'en_US';
        $user->email = 'admin@example.com';
        $session->set('user', $user);

        $request = $this->createRequest('GET', '/logout');
        $response = $this->app->handle($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertNull($session->get('user'));
    }
}
