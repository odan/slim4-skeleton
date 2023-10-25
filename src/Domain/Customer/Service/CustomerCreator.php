<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use Psr\Log\LoggerInterface;

final class CustomerCreator
{
    private CustomerRepository $repository;

    private CustomerValidator $customerValidator;

    private LoggerInterface $logger;

    public function __construct(
        CustomerRepository $repository,
        CustomerValidator $customerValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->customerValidator = $customerValidator;
        $this->logger = $logger;
    }

    public function createCustomer(array $data): int
    {
        // Input validation
        $this->customerValidator->validateCustomer($data);

        // Insert customer and get new customer ID
        $customerId = $this->repository->insertCustomer($data);

        // Logging
        $this->logger->info(sprintf('Customer created successfully: %s', $customerId));

        return $customerId;
    }
}
