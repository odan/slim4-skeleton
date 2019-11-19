<?php

namespace App\Test\TestCase;

use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\App;
use UnexpectedValueException;

/**
 * Container Trait.
 */
trait ContainerTestTrait
{
    /** @var ContainerInterface|Container|null */
    protected $container;

    /** @var App|null */
    protected $app;

    /**
     * Bootstrap app.
     *
     * @return void
     */
    protected function bootApp(): void
    {
        $this->app = require __DIR__ . '/../../config/bootstrap.php';
        $this->container = $this->app->getContainer();
    }

    /**
     * Shutdown app.
     *
     * @return void
     */
    protected function shutdownApp(): void
    {
        $this->app = null;
        $this->container = null;
    }

    /**
     * Get container.
     *
     * @throws UnexpectedValueException
     *
     * @return ContainerInterface|Container The container
     */
    protected function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            throw new UnexpectedValueException('Container must be initialized');
        }

        return $this->container;
    }

    /**
     * Get app.
     *
     * @throws UnexpectedValueException
     *
     * @return App The app
     */
    protected function getApp(): App
    {
        if ($this->app === null) {
            throw new UnexpectedValueException('App must be initialized');
        }

        return $this->app;
    }
}
