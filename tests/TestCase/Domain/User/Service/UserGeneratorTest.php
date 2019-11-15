<?php

namespace App\Test\TestCase\Domain\User\Service;

use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Repository\UserGeneratorRepository;
use App\Domain\User\Service\UserCreator;
use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserGeneratorTest extends TestCase
{
    use UnitTestTrait;

    /**
     * Create instance.
     *
     * @return UserCreator The instance
     */
    protected function createInstance(): UserCreator
    {
        // Mock the required repositories
        $this->registerMock(UserGeneratorRepository::class);

        return $this->getContainer()->get(UserCreator::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $service = $this->createInstance();

        $this->mockMethod([UserGeneratorRepository::class, 'insertUser'])->willReturn(1);

        $user = new UserCreatorData();
        $user->username = 'john.doe';
        $user->email = 'john.doe@example.com';
        $user->firstName = 'John';
        $user->lastName = 'Doe';

        $actual = $service->createUser($user);

        static::assertSame(1, $actual);
    }
}
