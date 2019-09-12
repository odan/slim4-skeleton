<?php

namespace App\Test\TestCase\Domain\User;

use App\Domain\User\UserCreator;
use App\Domain\User\UserCreatorRepository;
use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserCreatorTest extends TestCase
{
    use UnitTestTrait;

    /**
     * Create instance.
     *
     * @return UserCreator The instance
     */
    protected function createService(): UserCreator
    {
        // Mock the required repositories
        $this->registerMock(UserCreatorRepository::class);

        return $this->getContainer()->get(UserCreator::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $service = $this->createService();

        $this->mockMethod([UserCreatorRepository::class, 'insertUser'])->willReturn(1);

        $actual = $service->createUser([
            'username' => 'admin',
            'email' => 'mail@example.com'
        ]);

        static::assertSame(1, $actual);
    }
}
