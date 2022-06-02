<?php

namespace App\Transformer;

use App\Domain\Customer\Data\CustomerReaderResult;

final class CustomerReaderTransformer
{
    public function toArray(CustomerReaderResult $customer): array
    {
        return [
            'id' => $customer->id,
            'number' => $customer->number,
            'name' => $customer->name,
            'street' => $customer->street,
            'postal_code' => $customer->postalCode,
            'city' => $customer->city,
            'country' => $customer->country,
            'email' => $customer->email,
        ];
    }
}
