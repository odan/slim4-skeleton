<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserUpdaterRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class UserUpdater
{
    /**
     * @var UserUpdaterRepository
     */
    private $repository;

    /**
     * @var UserValidator
     */
    private $userValidator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param UserUpdaterRepository $repository The repository
     * @param UserValidator $userValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        UserUpdaterRepository $repository,
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

        // Map form data to row
        $userRow = $this->mapToUserRow($data);

        // Insert user
        $this->repository->updateUser($userId, $userRow);

        // Logging
        $this->logger->info(sprintf('User updated successfully: %s', $userId));
    }

    /**
     * Map data to row.
     *
     * @param array<mixed> $data The data
     *
     * @return array<mixed> The row
     */
    private function mapToUserRow(array $data): array
    {
        $result = [];

        if (isset($data['username'])) {
            $result['username'] = (string)$data['username'];
        }

        if (isset($data['password'])) {
            $result['password'] = (string)password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (isset($data['email'])) {
            $result['email'] = (string)$data['email'];
        }

        if (isset($data['first_name'])) {
            $result['first_name'] = (string)$data['first_name'];
        }

        if (isset($data['last_name'])) {
            $result['last_name'] = (string)$data['last_name'];
        }

        if (isset($data['user_role_id'])) {
            $result['user_role_id'] = (int)$data['user_role_id'];
        }

        if (isset($data['locale'])) {
            $result['locale'] = (string)$data['locale'];
        }

        if (isset($data['enabled'])) {
            $result['enabled'] = (int)$data['enabled'];
        }

        return $result;
    }
}
