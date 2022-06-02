<?php

namespace App\Domain\Customer\Data;

/**
 * DTO.
 */
final class CustomerReaderResult
{
    public ?int $id = null;

    public ?string $number = null;

    public ?string $name = null;

    public ?string $street = null;

    public ?string $postalCode = null;

    public ?string $city = null;

    public ?string $country = null;

    public ?string $email = null;
}
