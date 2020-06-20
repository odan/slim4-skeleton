<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param UserCreatorRepository $repository The repository
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        UserCreatorRepository $repository,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory
            ->addFileHandler('user_creator.log')
            ->createInstance('user_creator');
    }

    /**
     * Create a new user.
     *
     * @param array $form The form data
     *
     * @throws ValidationException
     *
     * @return int The new user ID
     */
    public function createUserFromArray(array $form): int
    {
        // Input validation
        $this->validateFormData($form);

        // Map form data to row
        $userRow = $this->createUserRow($form);

        // Insert user
        $userId = $this->repository->insertUser($userRow);

        // Logging
        $this->logger->info(__('User created successfully: %s', $userId));

        return $userId;
    }

    /**
     * Validate.
     *
     * @param array $form The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateFormData(array $form): void
    {
        $validation = new ValidationResult();

        if (empty($form['username'])) {
            $validation->addError('username', __('Input required'));
        }

        if (empty($form['email'])) {
            $validation->addError('email', __('Input required'));
        } elseif (filter_var($form['email'], FILTER_VALIDATE_EMAIL) === false) {
            $validation->addError('email', __('Invalid email address'));
        }

        if ($validation->fails()) {
            throw new ValidationException(__('Please check your input'), $validation);
        }
    }

    /**
     * Create row from form data.
     *
     * @param array $form The form data
     *
     * @return array The row
     */
    private function createUserRow(array $form): array
    {
        return [
            'username' => $form['username'],
            'email' => $form['email'],
            'first_name' => $form['first_name'] ?? null,
            'last_name' => $form['last_name'] ?? null,
        ];
    }
}
