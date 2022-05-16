<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerDeleter
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
     * Delete customer.
     *
     * @param int $customerId The customer id
     *
     * @return void
     */
    public function deleteCustomer(int $customerId): void
    {
        // Input validation
        // ...

        $this->repository->deleteCustomerById($customerId);
    }
}
