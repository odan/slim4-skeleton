<?php

use Laminas\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\CollectionStrategy;

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
    $hydrator = new ReflectionHydrator();
    $hydrator->setNamingStrategy(new UnderscoreNamingStrategy());
    $strategy = new CollectionStrategy($hydrator, $class);

    /** @var T[] $result */
    $result = $strategy->hydrate($items);

    return $result;
}
