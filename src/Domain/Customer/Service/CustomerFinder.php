<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Data\CustomerFinderItem;
use App\Domain\Customer\Data\CustomerFinderResult;
use App\Domain\Customer\Repository\CustomerFinderRepository;

/**
 * Service.
 */
final class CustomerFinder
{
    private CustomerFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param CustomerFinderRepository $repository The repository
     */
    public function __construct(CustomerFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find customers.
     *
     * @return CustomerFinderResult The result
     */
    public function findCustomers(): CustomerFinderResult
    {
        // Input validation
        // ...

        $customers = $this->repository->findCustomers();

        // Map data
        return $this->createResult($customers);
    }

    /**
     * Transform result.
     *
     * @param array $customerRows The customers
     *
     * @return CustomerFinderResult The result
     */
    private function createResult(array $customerRows): CustomerFinderResult
    {
        $result = new CustomerFinderResult();

        foreach ($customerRows as $customerRow) {
            $customer = new CustomerFinderItem();
            $customer->id = $customerRow['id'];
            $customer->number = $customerRow['number'];
            $customer->name = $customerRow['name'];
            $customer->street = $customerRow['street'];
            $customer->postalCode = $customerRow['postal_code'];
            $customer->city = $customerRow['city'];
            $customer->country = $customerRow['country'];
            $customer->email = $customerRow['email'];

            $result->customers[] = $customer;
        }

        return $result;
    }
}
