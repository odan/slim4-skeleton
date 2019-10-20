<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserData;
use App\Interfaces\ServiceInterface;
use Selective\ArrayReader\ArrayReader;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

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
     * @param array $form The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $form): int
    {
        // Validation
        $validation = $this->validateForm($form);

        if ($validation->isFailed()) {
            $validation->setMessage(__('Please check your input'));

            throw new ValidationException($validation);
        }

        return $this->userCreator->createUser(new UserData($form));
    }

    /**
     * Validate form.
     *
     * @param array $form The form data
     *
     * @return ValidationResult The validation result
     */
    private function validateForm(array $form): ValidationResult
    {
        $validation = new ValidationResult();
        $data = new ArrayReader($form);

        if ($data->isEmpty('email')) {
            $validation->addError('email', __('Input required'));
        }

        return $validation;
    }
}
