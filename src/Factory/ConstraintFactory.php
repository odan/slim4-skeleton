<?php

namespace App\Factory;

use Symfony\Component\Validator\Constraints as Assert;

final class ConstraintFactory
{
    public function collection(array $fields = null): Assert\Collection
    {
        return new Assert\Collection($fields);
    }

    public function required(array $options): Assert\Required
    {
        return new Assert\Required($options);
    }

    public function optional(array $options): Assert\Optional
    {
        return new Assert\Optional($options);
    }

    public function notBlank(): Assert\NotBlank
    {
        return new Assert\NotBlank();
    }

    public function length(int $min = null, int $max = null): Assert\Length
    {
        return new Assert\Length(['min' => $min, 'max' => $max]);
    }

    public function positive(): Assert\Positive
    {
        return new Assert\Positive();
    }

    public function email(): Assert\Email
    {
        return new Assert\Email();
    }
}
