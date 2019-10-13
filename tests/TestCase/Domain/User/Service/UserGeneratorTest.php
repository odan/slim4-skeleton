<?php

namespace App\Test\TestCase\Domain\User\Service;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserGeneratorRepository;
use App\Domain\User\Service\UserGenerator;
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
     * @return UserGenerator The instance
     */
    protected function createInstance(): UserGenerator
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
        $service = $this->createInstance();

        $this->mockMethod([UserGeneratorRepository::class, 'insertUser'])->willReturn(1);

        $user = new User();
        $user->username = 'john.doe';
        $user->email = 'john.doe@example.com';
        $user->firstName = 'John';
        $user->lastName = 'Doe';

        $actual = $service->createUser($user);

        static::assertSame(1, $actual);
    }
}
