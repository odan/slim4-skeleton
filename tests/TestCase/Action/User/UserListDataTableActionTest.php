<?php

namespace App\Test\TestCase\Action\User;

use App\Test\Traits\AppTestTrait;
use App\Test\Traits\DatabaseTestTrait;
use App\Test\Traits\LoginTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserListDataTableActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;
    use LoginTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersDataTableAction(): void
    {
        $this->loginUser();
        $request = $this->createRequest('POST', '/users/datatable');
        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertJsonData([
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'draw' => 1,
            'data' => [],
        ], $response);
    }
}
