<?php

namespace App\Test\TestCase;

use DI\Container;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
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

    /**
     * Create a mocked class method.
     *
     * @param array|callable $method The class and method
     *
     * @return InvocationMocker The mocker
     */
    protected function mockMethod($method): InvocationMocker
    {
        return $this->mock((string)$method[0])->method((string)$method[1]);
    }
}
