<?php

namespace App\Utility;

use App\Domain\Type\TypeInterface;
use DomainException;
use ReflectionClass;

/**
 * Type inspector.
 */
final class TypeInspector implements TypeInterface
{
    /**
     * Check if code is valid.
     *
     * @param string $className The class name
     * @param mixed $typeValue The type value to check
     *
     * @return bool True if code exists
     */
    public static function existsValue(string $className, $typeValue): bool
    {
        $reflectionClass = new ReflectionClass($className);

        return in_array($typeValue, $reflectionClass->getConstants(), true);
    }

    /**
     * Get name of constant by value.
     *
     * @param string $className The class name
     * @param int|string $typeValue The value
     *
     * @throws DomainException
     *
     * @return string Name
     */
    public static function getName(string $className, $typeValue): string
    {
        $reflectionClass = new ReflectionClass($className);
        $constants = array_flip($reflectionClass->getConstants());

        if (!array_key_exists($typeValue, $constants)) {
            throw new DomainException(__('Invalid type ID: %s', $typeValue));
        }

        return $constants[$typeValue];
    }
}
