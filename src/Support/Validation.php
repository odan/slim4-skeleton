<?php

namespace App\Support;

use Cake\Validation\Validator;
use Selective\Validation\Converter\CakeValidationConverter;
use Selective\Validation\ValidationResult;

/**
 * Validation.
 */
final class Validation
{
    /**
     * Create a validator.
     *
     * @return Validator The validator
     */
    public function createValidator(): Validator
    {
        return new Validator();
    }

    /**
     * Validates and returns an array of failed fields and their error messages.
     *
     * @param Validator $validator The validator
     * @param array $data The data to be checked for errors
     *
     * @return ValidationResult The object with failed fields
     */
    public function validate(Validator $validator, array $data): ValidationResult
    {
        return (new CakeValidationConverter())->createValidationResult($validator->validate($data));
    }
}
