<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;
use DomainException;

final class CustomerValidator
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateCustomerUpdate(int $customerId, array $data): void
    {
        if (!$this->repository->existsCustomerId($customerId)) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }

        $this->validateCustomer($data);
    }

    public function validateCustomer(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('number', true, 'Input required')
            ->notEmptyString('number', 'Input required')
            ->maxLength('number', 10, 'Too long')
            ->naturalNumber('number', 'Invalid number')
            ->requirePresence('name', true, 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 255, 'Too long')
            ->requirePresence('street', true, 'Input required')
            ->notEmptyString('street', 'Input required')
            ->maxLength('street', 255, 'Too long')
            ->requirePresence('postal_code', true, 'Input required')
            ->notEmptyString('postal_code', 'Input required')
            ->maxLength('postal_code', 10, 'Too long')
            ->requirePresence('city', true, 'Input required')
            ->notEmptyString('city', 'Input required')
            ->maxLength('city', 255, 'Too long')
            ->requirePresence('country', true, 'Input required')
            ->notEmptyString('country', 'Input required')
            ->maxLength('country', 2, 'Too long')
            ->requirePresence('country', true, 'Input required')
            ->notEmptyString('country', 'Input required')
            ->maxLength('country', 2, 'Must be exact 2 characters')
            ->minLength('country', 2, 'Must be exact 2 characters')
            ->requirePresence('email', true, 'Input required')
            ->notEmptyString('email', 'Input required')
            ->email('email', false, 'Invalid email address');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
