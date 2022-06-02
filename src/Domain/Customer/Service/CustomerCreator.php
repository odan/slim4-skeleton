<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class CustomerCreator
{
    private CustomerRepository $repository;

    private CustomerValidator $customerValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param CustomerRepository $repository The repository
     * @param CustomerValidator $customerValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        CustomerRepository $repository,
        CustomerValidator $customerValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->customerValidator = $customerValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('customer_creator.log')
            ->createLogger();
    }

    /**
     * Create a new customer.
     *
     * @param array $data The form data
     *
     * @return int The new customer ID
     */
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
