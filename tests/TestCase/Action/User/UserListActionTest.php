<?php

namespace App\Test\TestCase\Action\User;

use App\Domain\User\Data\UserAuthData;
use App\Test\TestCase\HttpTestTrait;
use Odan\Session\SessionInterface;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

/**
 * Test.
 */
class UserListActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersWithoutLoginAction(): void
    {
        $request = $this->createRequest('GET', '/users');
        $response = $this->request($request);

        static::assertSame(302, $response->getStatusCode());
    }

    /**
     * Login user.
     *
     * @return void
     */
    private function loginUser(): void
    {
        $user = new UserAuthData();
        $user->id = 1;
        $user->locale = 'en_US';
        $session = $this->getContainer()->get(SessionInterface::class);

        if ($session === null) {
            throw new UnexpectedValueException('Session not defined');
        }

        $session->set('user', $user);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersWithLoginAction(): void
    {
        $this->loginUser();
        $request = $this->createRequest('GET', '/users');
        $response = $this->request($request);

        static::assertSame(200, $response->getStatusCode());
        static::assertStringContainsString('User list', (string)$response->getBody());
    }
}
