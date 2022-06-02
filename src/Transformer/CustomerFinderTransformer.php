<?php

namespace App\Transformer;

use App\Domain\Customer\Data\CustomerFinderResult;

final class CustomerFinderTransformer
{
    public function toArray(CustomerFinderResult $collection): array
    {
        $data = [
            'customers' => [],
        ];

        foreach ($collection->customers as $customer) {
            $data['customers'][] = [
                'id' => (int)$customer->id,
                'number' => $customer->number,
                'name' => $customer->name,
                'street' => $customer->street,
                'postal_code' => $customer->postalCode,
                'city' => $customer->city,
                'country' => $customer->country,
                'email' => $customer->email,
            ];
        }

        return $data;
    }
}
