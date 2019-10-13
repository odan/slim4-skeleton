<?php

namespace App\Domain\User\Service;

use App\Domain\Service\DomainServiceInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserGeneratorRepository;
use App\Domain\User\Validator\UserValidator;
use App\Factory\LoggerFactory;
use Odan\Validation\ValidationException;
use Psr\Log\LoggerInterface;

/**
 * Domain Service.
 */
final class UserGenerator implements DomainServiceInterface
{
    /**
     * @var UserGeneratorRepository
     */
    private $repository;

    /**
     * @var UserValidator
     */
    protected $userValidator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param UserGeneratorRepository $repository The repository
     * @param UserValidator $userValidator The user validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        UserGeneratorRepository $repository,
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
     * @param User $user The user data
     *
     * @throws ValidationException
     *
     * @return int The new user ID
     */
    public function createUser(User $user): int
    {
        // Validation
        $validation = $this->userValidator->validateUser($user);

        if ($validation->isFailed()) {
            $validation->setMessage(__('Please check your input'));

            throw new ValidationException($validation);
        }

        // Insert user
        $userId = $this->repository->insertUser($user);

        // Logging
        $this->logger->info(__('User created successfully: %s', $userId));

        return $userId;
    }
}
