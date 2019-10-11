<?php

namespace App\Domain\User;

use App\Domain\Service\DomainServiceInterface;
use App\Domain\User\Data\UserData;
use Odan\Validation\ValidationException;
use Odan\Validation\ValidationResult;
use stdClass;

/**
 * Service.
 */
final class UserForm implements DomainServiceInterface
{
    /**
     * @var UserCreator
     */
    private $userCreator;

    /**
     * The constructor.
     *
     * @param UserCreator $userCreator The user creator
     */
    public function __construct(UserCreator $userCreator)
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

        // Map form to DTO
        $user = new UserData();
        $user->firstName = $form->first_name;
        $user->lastName = $form->last_name;
        $user->email = $form->email->a->a->a;

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
        } elseif (filter_var($form->email, FILTER_VALIDATE_EMAIL) !== false) {
            $validation->addError('email', __('Invalid email address'));
        }

        return $validation;
    }
}
