<?php

namespace App\Test\TestCase;

use DI\Container;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Unit test.
 */
trait UnitTestTrait
{
    use ContainerTestTrait;

    /** {@inheritdoc} */
    protected function setUp(): void
    {
        $this->bootApp();
    }

    /** {@inheritdoc} */
    protected function tearDown(): void
    {
        $this->shutdownApp();
    }

    /**
     * Add mock to container.
     *
     * @param string $class The class or interface
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

        $container = $this->getContainer();
        if ($container instanceof Container) {
            $container->set($class, $mock);
        }

        return $mock;
    }
}
