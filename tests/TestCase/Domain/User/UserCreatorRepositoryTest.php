<?php

namespace App\Test\TestCase\Domain\User;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Test\Fixture\UserFixture;
use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserCreatorRepositoryTest extends TestCase
{
    use UnitTestTrait;

    //use DatabaseTestTrait;

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

        $actual = $repository->insertUser([
            'username' => 'admin',
            'email' => 'mail@example.com',
        ]);

        static::assertSame(1, $actual);
    }
}
