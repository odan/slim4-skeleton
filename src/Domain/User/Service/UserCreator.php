<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Domain\User\Type\UserRoleType;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class UserCreator
{
    /**
     * @var UserCreatorRepository
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
     * @param UserCreatorRepository $repository The repository
     * @param UserValidator $userValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        UserCreatorRepository $repository,
        UserValidator $userValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->userValidator = $userValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('user_creator.log')
            ->createInstance('user_creator');
    }

    /**
     * Create a new user.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $data): int
    {
        // Input validation
        $this->userValidator->validateUser($data);

        // Map form data to row
        $userRow = $this->mapToUserRow($data);

        // Insert user
        $userId = $this->repository->insertUser($userRow);

        // Logging
        $this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
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
        return [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'email' => $data['email'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'user_role_id' => $data['user_role_id'] ?? UserRoleType::ROLE_USER,
            'locale' => $data['locale'] ?? 'en_US',
            'enabled' => (int)($data['enabled'] ?? true),
        ];
    }
}
