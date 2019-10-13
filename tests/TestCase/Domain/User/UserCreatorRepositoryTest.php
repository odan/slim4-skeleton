<?php

namespace App\Test\TestCase\Domain\User;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserGeneratorRepository;
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
     * @return UserGeneratorRepository The instance
     */
    protected function createRepository(): UserGeneratorRepository
    {
        return $this->getContainer()->get(UserGeneratorRepository::class);
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
        $user->username = 'john.doe';
        $user->email = 'john.doe@example.com';
        $user->firstName = 'John';
        $user->lastName = 'Doe';

        $actual = $repository->insertUser($user);

        static::assertSame(3, $actual);
    }
}
