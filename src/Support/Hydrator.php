<?php

namespace App\Support;

/**
 * Hydrator.
 */
final class Hydrator
{
    /**
     * Hydrate a collection of objects with data from an array with multiple items.
     *
     * @template T
     *
     * @param array $data The items
     * @param class-string<T> $class The FQN
     *
     * @return T[] The list of object
     */
    public function hydrate(array $data, string $class): array
    {
        /** @var T[] $result */
        $result = [];

        foreach ($data as $item) {
            $result[] = new $class($item);
        }

        return $result;
    }
}
