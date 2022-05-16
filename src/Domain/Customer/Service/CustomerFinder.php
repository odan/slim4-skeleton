<?php

namespace App\Domain\Customer\Service;

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
     * @return array A list of customers
     */
    public function findCustomers(): array
    {
        // Input validation
        // ...

        $customers = $this->repository->findCustomers();

        // Map data
        return $this->transform($customers);
    }

    /**
     * Transform result.
     *
     * @param array $customerRows The customers
     *
     * @return array The result
     */
    private function transform(array $customerRows): array
    {
        $customers = [];

        foreach ($customerRows as $customerRow) {
            $customers[] = [
                'id' => (int)$customerRow['id'],
                'number' => $customerRow['number'],
                'name' => $customerRow['name'],
                'street' => $customerRow['street'],
                'postal_code' => $customerRow['postal_code'],
                'city' => $customerRow['city'],
                'country' => $customerRow['country'],
                'email' => $customerRow['email'],
            ];
        }

        return [
            'customers' => $customers,
        ];
    }
}
