<?php

namespace App\Support\Validation;

use DomainException;
use Throwable;

final class ValidationException extends DomainException
{
    private ?ValidationResult $validationResult;

    public function __construct(
        string $message,
        ValidationResult $validationResult = null,
        int $code = 422,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->validationResult = $validationResult;
    }

    public function getValidationResult(): ?ValidationResult
    {
        return $this->validationResult;
    }
}
