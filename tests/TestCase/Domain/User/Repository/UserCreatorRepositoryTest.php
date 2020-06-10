<?php

namespace App\Test\TestCase\Domain\User\Repository;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Test\DatabaseTestTrait;
use App\Test\Fixture\UserFixture;
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
    protected function createInstance(): UserCreatorRepository
    {
        return $this->container->get(UserCreatorRepository::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInsertUser(): void
    {
        $repository = $this->createInstance();

        $user = [
            'username' => 'john.doe',
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $actual = $repository->insertUser($user);

        $this->assertSame(3, $actual);
    }
}
