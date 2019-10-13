<?php

namespace App\Test\TestCase\Domain\User;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserGeneratorRepository;
use App\Domain\User\UserGenerator;
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
     * @return UserGenerator The instance
     */
    protected function createService(): UserGenerator
    {
        // Mock the required repositories
        $this->registerMock(UserGeneratorRepository::class);

        return $this->getContainer()->get(UserGenerator::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $service = $this->createService();

        $this->mockMethod([UserGeneratorRepository::class, 'insertUser'])->willReturn(1);

        $user = new UserData();
        $user->username = 'john.doe';
        $user->email = 'john.doe@example.com';
        $user->firstName = 'John';
        $user->lastName = 'Doe';

        $actual = $service->createUser($user);

        static::assertSame(1, $actual);
    }
}
