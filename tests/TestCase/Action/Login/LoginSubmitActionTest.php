<?php

namespace App\Test\TestCase\Action\Login;

use App\Domain\User\Data\UserSessionData;
use App\Test\Fixture\UserFixture;
use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Test.
 */
class LoginSubmitActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testLoginAdminAction(): void
    {
        $this->insertFixtures([
            UserFixture::class,
        ]);

        $request = $this->createRequest('POST', '/login');
        $request = $this->withJson($request, ['username' => 'admin', 'password' => 'admin']);
        $response = $this->request($request);

        static::assertSame(302, $response->getStatusCode());
        static::assertSame('/users', $response->getHeaderLine('Location'));
        static::assertEquals('', (string)$response->getBody());

        // User session
        $session = $this->getContainer()->get(Session::class);

        /** @var UserSessionData $user */
        $user = $session->get('user');
        static::assertInstanceOf(UserSessionData::class, $user);
        static::assertSame(1, $user->id);
        static::assertSame('en_US', $user->locale);
        static::assertSame('admin@example.com', $user->email);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testLoginUserAction(): void
    {
        $this->insertFixtures([
            UserFixture::class,
        ]);

        $request = $this->createRequest('POST', '/login');
        $request = $this->withJson($request, ['username' => 'user', 'password' => 'user']);
        $response = $this->request($request);

        static::assertSame(302, $response->getStatusCode());
        static::assertSame('/users', $response->getHeaderLine('Location'));
        static::assertEquals('', (string)$response->getBody());

        // User session
        $session = $this->getContainer()->get(Session::class);

        /** @var UserSessionData $user */
        $user = $session->get('user');
        static::assertInstanceOf(UserSessionData::class, $user);
        static::assertSame(2, $user->id);
        static::assertSame('de_DE', $user->locale);
        static::assertSame('user@example.com', $user->email);
    }
}
