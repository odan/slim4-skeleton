<?php

namespace App\Test\TestCase;

use DI\Container;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use UnexpectedValueException;

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
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function registerMock(string $class): void
    {
        $container = $this->getContainer();

        if ($container instanceof Container) {
            $container->set($class, $this->createMockObject($class));

            return;
        }

        throw new UnexpectedValueException(sprintf('The class could not be mocked: %s', $class));
    }

    /**
     * Mocking an interface.
     *
     * @param string $class The interface / class name
     *
     * @throws InvalidArgumentException
     *
     * @return MockObject The mock
     */
    protected function createMockObject(string $class): MockObject
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Class not found: %s', $class));
        }

        $reflection = new ReflectionClass($class);
        $methods = [];

        foreach ($reflection->getMethods() as $method) {
            $methods[] = $method->name;
        }

        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    /**
     * Create a mocked class method.
     *
     * @param array|callable $method The class and method
     *
     * @return InvocationMocker
     */
    protected function mockMethod($method): InvocationMocker
    {
        /** @var MockObject $mock */
        $mock = $this->getContainer()->get((string)$method[0]);

        return $mock->method((string)$method[1]);
    }
}
