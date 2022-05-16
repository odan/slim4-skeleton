<?php

namespace App\Test\Fixture;

/**
 * Fixture.
 */
class CustomerFixture
{
    public string $table = 'customers';

    public array $records = [
        [
            'id' => '1',
            'number' => '10000',
            'name' => 'Coho Winery',
            'street' => '192 Market Square',
            'postal_code' => '31772',
            'city' => 'Atlanta',
            'country' => 'US',
            'email' => 'info@example.net',
        ],
        [
            'id' => '2',
            'number' => '10001',
            'name' => 'Contoso AG',
            'street' => '4928 Tori Lane',
            'postal_code' => '84116',
            'city' => 'Salt Lake City',
            'country' => 'US',
            'email' => 'info@contoso.com',
        ],
    ];
}
