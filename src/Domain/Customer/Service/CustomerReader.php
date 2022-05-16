<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerReader
{
    private CustomerRepository $repository;

    /**
     * The constructor.
     *
     * @param CustomerRepository $repository The repository
     */
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a customer.
     *
     * @param int $customerId The customer id
     *
     * @return array The result
     */
    public function getCustomer(int $customerId): array
    {
        // Input validation
        // ...

        // Fetch data from the database
        $customer = $this->repository->getCustomerById($customerId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Map result
        return $this->transform($customer);
    }

    /**
     * Transform result.
     *
     * @param array $customer The customer
     *
     * @return array The result
     */
    private function transform(array $customer): array
    {
        return [
            'id' => (int)$customer['id'],
            'number' => $customer['number'],
            'name' => $customer['name'],
            'street' => $customer['street'],
            'postal_code' => $customer['postal_code'],
            'city' => $customer['city'],
            'country' => $customer['country'],
            'email' => $customer['email'],
        ];
    }
}
