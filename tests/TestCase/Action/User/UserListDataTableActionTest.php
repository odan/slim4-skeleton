<?php

namespace App\Test\TestCase\Action\User;

use App\Test\TestCase\HttpTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class UserListDataTableActionTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUsersDataTableAction(): void
    {
        $this->loginUser();
        $request = $this->createRequest('POST', '/users/datatable');
        $response = $this->request($request);

        static::assertSame(200, $response->getStatusCode());
        static::assertStringContainsString(
            '{"recordsTotal":0,"recordsFiltered":0,"draw":1,"data":[]}',
            (string)$response->getBody()
        );
    }
}
