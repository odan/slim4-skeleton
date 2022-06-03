<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CustomerUpdater
{
    private CustomerRepository $repository;

    private CustomerValidator $customerValidator;

    private LoggerInterface $logger;

    public function __construct(
        CustomerRepository $repository,
        CustomerValidator $customerValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->customerValidator = $customerValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('customer_updater.log')
            ->createLogger();
    }

    public function updateCustomer(int $customerId, array $data): void
    {
        // Input validation
        $this->customerValidator->validateCustomerUpdate($customerId, $data);

        // Update the row
        $this->repository->updateCustomer($customerId, $data);

        // Logging
        $this->logger->info(sprintf('Customer updated successfully: %s', $customerId));
    }
}
