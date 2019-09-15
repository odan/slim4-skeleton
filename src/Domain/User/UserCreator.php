<?php

namespace App\Domain\User;

use App\Domain\Base\DomainServiceInterface;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Domain Service
 */
final class UserCreator implements DomainServiceInterface
{
    /**
     * @var UserCreatorRepository
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param UserCreatorRepository $repository The repository
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(UserCreatorRepository $repository, LoggerFactory $loggerFactory)
    {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('user_creator.log')->createInstance('user_creator');
    }

    /**
     * Create a new user.
     *
     * @param array $userData The user data
     *
     * @return int The new ID
     */
    public function createUser(array $userData): int
    {
        // Validation
        // ...

        // Insert user
        $userId = $this->repository->insertUser($userData);

        // Logging
        $this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }
}
