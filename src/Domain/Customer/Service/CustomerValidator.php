<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

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
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        return new Assert\Collection(
            [
                'number' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 0, 'max' => 10]),
                        new Assert\Positive(),
                    ]
                ),
                'name' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['max' => 255]),
                    ]
                ),
                'street' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['max' => 255]),
                    ]
                ),
                'postal_code' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['max' => 10]),
                    ]
                ),
                'city' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['max' => 255]),
                    ]
                ),
                'country' => new Assert\Required(
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 2]),
                    ]
                ),
                'email' => new Assert\Required(
                    [
                        new Assert\Email(),
                    ]
                ),
            ]
        );
    }
}
