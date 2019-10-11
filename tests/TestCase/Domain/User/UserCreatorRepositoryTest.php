<?php

namespace App\Test\TestCase\Domain\User;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserCreatorRepository;
use App\Test\Fixture\UserFixture;
use App\Test\TestCase\DatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserCreatorRepositoryTest extends TestCase
{
    use DatabaseTestTrait;

    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        UserFixture::class,
    ];

    /**
     * Create instance.
     *
     * @return UserCreatorRepository The instance
     */
    protected function createRepository(): UserCreatorRepository
    {
        return $this->getContainer()->get(UserCreatorRepository::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInsertUser(): void
    {
        $repository = $this->createRepository();

        $user = new UserData();
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->email = 'john.doe@example.com';
        $user->userName = 'john.doe';

        $actual = $repository->insertUser($user);

        static::assertSame(3, $actual);
    }
}
