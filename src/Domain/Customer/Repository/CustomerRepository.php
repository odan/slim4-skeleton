<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class CustomerRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertCustomer(array $customer): int
    {
        return (int)$this->queryFactory->newInsert('customers', $this->toRow($customer))
            ->execute()
            ->lastInsertId();
    }

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

    public function updateCustomer(int $customerId, array $customer): void
    {
        $row = $this->toRow($customer);

        $this->queryFactory->newUpdate('customers', $row)
            ->where(['id' => $customerId])
            ->execute();
    }

    public function existsCustomerId(int $customerId): bool
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select('id')->where(['id' => $customerId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCustomerById(int $customerId): void
    {
        $this->queryFactory->newDelete('customers')
            ->where(['id' => $customerId])
            ->execute();
    }

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
