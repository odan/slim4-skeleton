<?php

namespace App\Test\TestCase\Action\Customer;

use App\Test\Fixture\CustomerFixture;
use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Customer\CustomerReaderAction
 */
class CustomerReaderActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testValidId(): void
    {
        $this->insertFixtures([CustomerFixture::class]);

        $request = $this->createRequest('GET', '/api/customers/1');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'id' => 1,
                'number' => '10000',
                'name' => 'Coho Winery',
                'street' => '192 Market Square',
                'postal_code' => '31772',
                'city' => 'Atlanta',
                'country' => 'US',
                'email' => 'info@example.net',
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidId(): void
    {
        $request = $this->createRequest('GET', '/api/customers/99');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
