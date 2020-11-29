<?php

namespace App\Test\Traits;

use Psr\Container\ContainerInterface;
use UnexpectedValueException;

/**
 * Container Test Trait.
 */
trait ContainerTestTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Bootstrap app.
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
