<?php

namespace App\Test\Traits;

/**
 * Array Test Trait.
 */
trait ArrayTestTrait
{
    /**
     * Read array value with dot notation.
     *
     * @param array $data The array
     * @param string $path The path
     * @param mixed $default The default return value#
     *
     * @return mixed The value from the array or the default value
     */
    protected function getArrayValue(array $data, string $path, mixed $default = null): mixed
    {
        $currentValue = $data;
        $keyPaths = (array)explode('.', $path);

        foreach ($keyPaths as $currentKey) {
            if (isset($currentValue->$currentKey)) {
                $currentValue = $currentValue->$currentKey;
                continue;
            }
            if (isset($currentValue[$currentKey])) {
                $currentValue = $currentValue[$currentKey];
                continue;
            }

            return $default;
        }

        // @phpstan-ignore-next-line
        return $currentValue === null ? $default : $currentValue;
    }
}
