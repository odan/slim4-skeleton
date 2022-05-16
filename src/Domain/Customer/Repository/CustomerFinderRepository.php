<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class CustomerFinderRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Find customers.
     *
     * @return array A list of customers
     */
    public function findCustomers(): array
    {
        $query = $this->queryFactory->newSelect('customers');

        $query->select(
            [
                'id',
                'number',
                'name',
                'street',
                'postal_code',
                'city',
                'country',
                'email',
            ]
        );

        // Add more "use case specific" conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
