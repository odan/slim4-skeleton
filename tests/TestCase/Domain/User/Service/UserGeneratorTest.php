<?php

namespace App\Test\TestCase\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Domain\User\Service\UserCreator;
use App\Test\AppTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserGeneratorTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        // Mock the required repository method
        $this->mock(UserCreatorRepository::class)->method('insertUser')->willReturn(1);

        $service = $this->container->get(UserCreator::class);

        $user = [
            'username' => 'john.doe',
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $actual = $service->createUserFromArray($user);

        $this->assertSame(1, $actual);
    }
}
