<?php

namespace App\Factory;

use Cake\Validation\Validator;
use Selective\Validation\Converter\CakeValidationConverter;
use Selective\Validation\ValidationResult;

/**
 * Validation factory.
 */
final class ValidationFactory
{
    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    public function createValidator(): Validator
    {
        return new Validator();
    }

    /**
     * Create validation result from array with errors.
     *
     * @param array $errors The errors
     *
     * @return ValidationResult The result
     */
    public function createResultFromErrors(array $errors): ValidationResult
    {
        return CakeValidationConverter::createValidationResult($errors);
    }
}
