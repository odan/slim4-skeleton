<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class CustomerRepository
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
     * Insert customer.
     *
     * @param array $customer The customer data
     *
     * @return int The new ID
     */
    public function insertCustomer(array $customer): int
    {
        return (int)$this->queryFactory->newInsert('customers', $this->toRow($customer))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get customer by id.
     *
     * @param int $customerId The customer id
     *
     * @throws DomainException
     *
     * @return array The customer row
     */
    public function getCustomerById(int $customerId): array
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

        $query->where(['id' => $customerId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }

        return $row;
    }

    /**
     * Update customer row.
     *
     * @param int $customerId The customer id
     * @param array $customer The data
     *
     * @return void
     */
    public function updateCustomer(int $customerId, array $customer): void
    {
        $row = $this->toRow($customer);

        $this->queryFactory->newUpdate('customers', $row)
            ->where(['id' => $customerId])
            ->execute();
    }

    /**
     * Check customer id.
     *
     * @param int $customerId The customer id
     *
     * @return bool True if exists
     */
    public function existsCustomerId(int $customerId): bool
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select('id')->where(['id' => $customerId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete customer.
     *
     * @param int $customerId The customer id
     *
     * @return void
     */
    public function deleteCustomerById(int $customerId): void
    {
        $this->queryFactory->newDelete('customers')
            ->where(['id' => $customerId])
            ->execute();
    }

    /**
     * Convert to array.
     *
     * @param array $customer The customer data
     *
     * @return array The row
     */
    private function toRow(array $customer): array
    {
        return [
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
