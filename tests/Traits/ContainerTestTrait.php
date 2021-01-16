<?php

namespace App\Test\Traits;

use DI\Container;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;

/**
 * Container Test Trait.
 */
trait ContainerTestTrait
{
    /**
     * @var Container|ContainerInterface
     */
    protected $container;

    /**
     * Bootstrap app.
     *
     * TestCases must call this method inside setUp().
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function setUpContainer(): void
    {
        $container = $this->app->getContainer();
        if ($container === null) {
            throw new UnexpectedValueException('Container must be initialized');
        }

        $this->container = $container;
    }
}
