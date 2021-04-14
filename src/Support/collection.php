<?php

/**
 * Hydrate a collection of objects with data from an array with multiple items.
 *
 * @template T
 *
 * @param array $items The items
 * @param class-string<T> $class The FQN
 *
 * @return T[] The list of object
 */
function hydrate(array $items, string $class): array
{
    /** @var T[] $result */
    $result = [];

    foreach ($items as $item) {
        $result[] = new $class($item);
    }

    return $result;
}
