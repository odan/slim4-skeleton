<?php

namespace App\Test\TestCase\Domain\User\Repository;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Test\Fixture\UserFixture;
use App\Test\Traits\AppTestTrait;
use App\Test\Traits\DatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserCreatorRepositoryTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

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
        $this->insertFixtures([UserFixture::class]);

        $repository = $this->createInstance();

        $user = [
            'username' => 'john.doe',
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $actual = $repository->insertUser($user);

        $this->assertSame(3, $actual);
        $this->assertTableRowCount(3, 'users');

        $expected = [
            'id' => '3',
            'username' => 'john.doe',
            'password' => null,
            'email' => 'john.doe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role' => null,
            'locale' => null,
            'enabled' => '0',
            'created_at' => '2020-01-01 00:00:00',
            'created_user_id' => null,
            'updated_at' => null,
            'updated_user_id' => null,
        ];

        $this->assertTableRow($expected, 'users', 3);
        $this->assertTableRowValue('3', 'users', 3, 'id');
    }
}
