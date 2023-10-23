<?php

namespace App\Support\Validation;

final class ValidationResult
{
    private array $errors = [];

    public function __construct(array $errors = [])
    {
        $this->addErrors($errors);
    }

    private function addErrors(array $errors, string $path = ''): void
    {
        foreach ($errors as $field => $error) {
            $oldPath = $path;
            $path .= ($path === '' ? '' : '.') . $field;
            $this->addSubErrors($error, $path);
            $path = $oldPath;
        }
    }

    private function addSubErrors(array $error, string $path = ''): void
    {
        foreach ($error as $field2 => $errorMessage) {
            if (is_array($errorMessage)) {
                $this->addErrors([$field2 => $errorMessage], $path);
            } else {
                $this->addError($path, $errorMessage);
            }
        }
    }

    public function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function success(): bool
    {
        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !$this->success();
    }
}
