<?php

namespace App\Test\TestCase\Action\Customer;

use App\Test\Traits\AppTestTrait;
use Cake\Chronos\Chronos;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Customer\CustomerCreatorAction
 */
class CustomerCreatorActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateCustomer(): void
    {
        Chronos::setTestNow('2021-01-01 00:00:00');

        $request = $this->createJsonRequest(
            'POST',
            '/api/customers',
            [
                'number' => '10000',
                'name' => 'Coho Winery',
                'street' => '192 Market Square',
                'city' => 'Atlanta',
                'country' => 'US',
                'postal_code' => '31772',
                'email' => 'im.glynn@example.net',
            ]
        );
        $request = $this->withHttpBasicAuth($request);

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(['customer_id' => 1], $response);

        // Check logger
        $this->assertTrue($this->getLogger()->hasInfoThatContains('Customer created successfully'));

        // Check database
        $this->assertTableRowCount(1, 'customers');

        $expected = [
            'id' => '1',
            'number' => '10000',
            'name' => 'Coho Winery',
            'street' => '192 Market Square',
            'postal_code' => '31772',
            'city' => 'Atlanta',
            'country' => 'US',
            'email' => 'im.glynn@example.net',
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
        $request = $this->createJsonRequest(
            'POST',
            '/api/customers',
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
