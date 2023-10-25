<?php

namespace App\Support\Validation;

use DomainException;
use Throwable;

final class ValidationException extends DomainException
{
    private array $errors;

    public function __construct(
        string $message,
        array $errors = [],
        int $code = 422,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
