<?php

namespace App\Test\TestCase\Action\Customer;

use App\Test\Fixture\CustomerFixture;
use App\Test\Traits\AppTestTrait;
use Cake\Chronos\Chronos;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Customer\CustomerUpdaterAction
 */
class CustomerUpdaterActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUpdateCustomer(): void
    {
        Chronos::setTestNow('2021-02-01 00:00:00');

        $this->insertFixtures([CustomerFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/customers/1',
            [
                'number' => '19999',
                'name' => 'New name',
                'street' => 'New street',
                'city' => 'New city',
                'country' => 'DE',
                'postal_code' => '77777',
                'email' => 'new@example.com',
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);

        // Check logger
        $this->assertTrue($this->getLogger()->hasInfoThatContains('Customer updated successfully'));

        // Check database
        $expected = [
            'id' => '1',
            'number' => '19999',
            'name' => 'New name',
            'street' => 'New street',
            'postal_code' => '77777',
            'city' => 'New city',
            'country' => 'DE',
            'email' => 'new@example.com',
        ];

        $this->assertTableRow($expected, 'customers', 1);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateCustomerValidation(): void
    {
        $this->insertFixtures([CustomerFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/customers/1',
            [
                'number' => '',
                'name' => '',
                'street' => '',
                'city' => '',
                'country' => '',
                'postal_code' => '',
                'email' => 'mail.example.com',
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'error' => [
                    'message' => 'Please check your input',
                    'code' => 422,
                    'details' => [
                        [
                            'message' => 'Input required',
                            'field' => 'number',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'name',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'street',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'postal_code',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'city',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'country',
                        ],
                        [
                            'message' => 'Input required',
                            'field' => 'email',
                        ],
                    ],
                ],
            ],
            $response
        );
    }
}
