<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserUpdaterRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use Selective\Transformer\ArrayTransformer;

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
        $transformer = new ArrayTransformer();

        $transformer->map('username', 'username', 'string')
            ->map(
                'password',
                'password',
                $transformer->rule()->callback(
                    function ($password) {
                        return (string)password_hash($password, PASSWORD_DEFAULT);
                    }
                )
            )->map('email', 'email', 'string')
            ->map('first_name', 'first_name', 'string')
            ->map('last_name', 'last_name', 'string')
            ->map('user_role_id', 'user_role_id', 'int')
            ->map('locale', 'locale', 'string')
            ->map('enabled', 'enabled', 'int');

        return $transformer->toArray($data);
    }
}
