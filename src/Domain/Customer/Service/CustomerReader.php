<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Data\CustomerReaderResult;
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
     * @return CustomerReaderResult The result
     */
    public function getCustomer(int $customerId): CustomerReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $customerRow = $this->repository->getCustomerById($customerId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new CustomerReaderResult();
        $result->id = $customerRow['id'];
        $result->number = $customerRow['number'];
        $result->name = $customerRow['name'];
        $result->street = $customerRow['street'];
        $result->postalCode = $customerRow['postal_code'];
        $result->city = $customerRow['city'];
        $result->country = $customerRow['country'];
        $result->email = $customerRow['email'];

        return $result;
    }
}
