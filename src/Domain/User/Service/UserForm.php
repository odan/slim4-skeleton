<?php

namespace App\Domain\User\Service;

use App\Domain\Service\ServiceInterface;
use App\Domain\User\Mapper\UserMapper;
use App\Domain\User\Model\User;
use Odan\Validation\ValidationException;
use Odan\Validation\ValidationResult;
use stdClass;

/**
 * Service.
 */
final class UserForm implements ServiceInterface
{
    /**
     * @var UserGenerator
     */
    private $userCreator;

    /**
     * The constructor.
     *
     * @param UserGenerator $userCreator The user creator
     */
    public function __construct(UserGenerator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    /**
     * Create user.
     *
     * @param stdClass $form The form data
     *
     * @return int The new user ID
     */
    public function createUser(stdClass $form): int
    {
        // Validation
        $validation = $this->validateForm($form);

        if ($validation->isFailed()) {
            $validation->setMessage(__('Please check your input'));

            throw new ValidationException($validation);
        }

        $user = UserMapper::createFromObject($form);

        return $this->userCreator->createUser($user);
    }

    /**
     * Validate form.
     *
     * @param stdClass $form The form data
     *
     * @return ValidationResult The validation result
     */
    private function validateForm(stdClass $form): ValidationResult
    {
        $validation = new ValidationResult();

        if (empty($form->email)) {
            $validation->addError('email', __('Input required'));
        }

        return $validation;
    }
}
