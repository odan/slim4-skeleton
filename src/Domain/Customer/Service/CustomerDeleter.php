<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;

final class CustomerDeleter
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteCustomer(int $customerId): void
    {
        // Input validation
        // ...

        $this->repository->deleteCustomerById($customerId);
    }
}
