<?php

namespace App\Domain\Type;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Type inspector.
 */
final class TypeInspector implements TypeInterface
{
    /**
     * Check if code is valid.
     *
     * @param string $class The type class name
     * @param mixed $typeValue The type value to check
     *
     * @throws ReflectionException
     *
     * @return bool True if code exists
     */
    public static function existsValue(string $class, $typeValue): bool
    {
        $class = new ReflectionClass($class);

        return in_array($typeValue, $class->getConstants(), true);
    }

    /**
     * Get name of constant by value.
     *
     * @param string $class The type class name
     * @param int|string $typeValue The value
     *
     * @throws RuntimeException
     * @throws ReflectionException
     *
     * @return string Name
     */
    public static function getName(string $class, $typeValue): string
    {
        $class = new ReflectionClass($class);
        $constants = array_flip($class->getConstants());

        if (!array_key_exists($typeValue, $constants)) {
            throw new RuntimeException(__('Invalid type ID: %s', $typeValue));
        }

        return $constants[$typeValue];
    }
}
