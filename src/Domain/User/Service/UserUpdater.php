<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class UserUpdater
{
    private UserRepository $repository;

    private UserValidator $userValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     * @param UserValidator $userValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        UserRepository $repository,
        UserValidator $userValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->userValidator = $userValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('user_updater.log')
            ->createLogger();
    }

    /**
     * Update user.
     *
     * @param int $userId The user id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateUser(int $userId, array $data): void
    {
        // Input validation
        $this->userValidator->validateUserUpdate($userId, $data);

        // Validation was successfully
        $user = new UserData($data);
        $user->id = $userId;

        // Update the user
        $this->repository->updateUser($user);

        // Logging
        $this->logger->info(sprintf('User updated successfully: %s', $userId));
    }
}
