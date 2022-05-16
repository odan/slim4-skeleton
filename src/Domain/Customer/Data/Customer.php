<?php

namespace App\Domain\Customer\Data;

/**
 * Data Model.
 */
final class Customer
{
    public ?int $id = null;

    public ?string $number = null;

    public ?string $name = null;

    public ?string $street = null;

    public ?string $postal_code = null;

    public ?string $city = null;

    public ?string $country = null;

    public ?string $email = null;
}
