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
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        // Mock the required repositories
        $this->mock(UserCreatorRepository::class)
            ->method('insertUser')
            ->willReturn(1);

        $service = $this->getContainer()->get(UserCreator::class);

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
