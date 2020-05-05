<?php

namespace App\Test\TestCase\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
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
        $service = $this->createInstance();

        $this->mockMethod([UserCreatorRepository::class, 'insertUser'])->willReturn(1);

        $user = [
            'username' => 'john.doe',
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $actual = $service->createUserFromArray($user);

        static::assertSame(1, $actual);
    }
}
