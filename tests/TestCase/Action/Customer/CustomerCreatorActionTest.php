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

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(['customer_id' => 1], $response);

        // Check logger
        // No logger errors
        $this->assertSame([], $this->getLoggerErrors());
        $this->assertTrue($this->getLogger()->hasInfoThatContains('Customer created successfully: 1'));

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

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonContentType($response);

        $expected = [
            'error' => [
                'message' => 'Please check your input',
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
                        'message' => 'Invalid email address',
                        'field' => 'email',
                    ],
                ],
            ],
        ];

        $this->assertJsonData($expected, $response);
    }
}
