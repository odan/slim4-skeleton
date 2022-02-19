<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Type\UserRoleType;
use App\Support\Validation;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class UserValidator
{
    private UserRepository $repository;

    private Validation $validation;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     * @param Validation $validation The validation
     */
    public function __construct(UserRepository $repository, Validation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    /**
     * Validate update.
     *
     * @param int $userId The user id
     * @param array $data The data
     *
     * @return void
     */
    public function validateUserUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsUserId($userId)) {
            throw new ValidationException(sprintf('User not found: %s', $userId));
        }

        $this->validateUser($data);
    }

    /**
     * Validate new user.
     *
     * @param array $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateUser(array $data): void
    {
        $validator = $this->createValidator();
        $validationResult = $this->validation->validate($validator, $data);

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    private function createValidator(): Validator
    {
        $validator = $this->validation->createValidator();

        return $validator
            ->notEmptyString('username', 'Input required')
            ->notEmptyString('password', 'Input required')
            ->minLength('password', 8, 'Too short')
            ->maxLength('password', 40, 'Too long')
            ->email('email', false, 'Input required')
            ->inList('user_role_id', [UserRoleType::ROLE_USER, UserRoleType::ROLE_ADMIN], 'Invalid')
            ->notEmptyString('locale', 'Input required')
            ->regex('locale', '/^[a-z]{2}\_[A-Z]{2}$/', 'Invalid')
            ->boolean('enabled', 'Invalid');
    }
}
