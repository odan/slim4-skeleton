<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use App\Support\Validation;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class CustomerValidator
{
    private CustomerRepository $repository;

    private Validation $validation;

    public function __construct(CustomerRepository $repository, Validation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    public function validateCustomerUpdate(int $customerId, array $data): void
    {
        if (!$this->repository->existsCustomerId($customerId)) {
            throw new ValidationException(sprintf('Customer not found: %s', $customerId));
        }

        $this->validateCustomer($data);
    }

    public function validateCustomer(array $data): void
    {
        $validator = $this->createValidator();
        $validationResult = $this->validation->validate($validator, $data);

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    private function createValidator(): Validator
    {
        $validator = $this->validation->createValidator();

        return $validator
            ->requirePresence('number', 'Input required')
            ->notEmptyString('number', 'Input required')
            ->maxLength('number', 10, 'Too long')
            ->numeric('number', 'Invalid number')
            ->requirePresence('name', 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 255, 'Too long')
            ->requirePresence('street', 'Input required')
            ->notEmptyString('street', 'Input required')
            ->maxLength('street', 255, 'Too long')
            ->requirePresence('postal_code', 'Input required')
            ->notEmptyString('postal_code', 'Input required')
            ->maxLength('postal_code', 10, 'Too long')
            ->requirePresence('city', 'Input required')
            ->notEmptyString('city', 'Input required')
            ->maxLength('city', 255, 'Too long')
            ->requirePresence('country', 'Input required')
            ->notEmptyString('country', 'Input required')
            ->minLength('country', 2, 'Too short')
            ->maxLength('country', 2, 'Too long')
            ->requirePresence('email', 'Input required')
            ->email('email', false, 'Input required');
    }
}
