<?php

namespace App\Test\TestCase;

use DI\Container;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Mock Test Trait.
 */
trait MockTestTrait
{
    /**
     * Add mock to container.
     *
     * @param string $class The class or interface
     *
     * @throws InvalidArgumentException
     *
     * @return MockObject The mock
     */
    protected function mock(string $class): MockObject
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class not found: %s', $class));
        }

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($this->container instanceof Container) {
            $this->container->set($class, $mock);
        }

        return $mock;
    }
}
