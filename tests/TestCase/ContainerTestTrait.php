<?php

namespace App\Test\TestCase;

use App\Application;
use League\Container\Container;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Slim\App;

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
        $this->app = Application::boostrap();
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
     * @throws RuntimeException
     *
     * @return ContainerInterface|Container The container
     */
    protected function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            throw new RuntimeException('Container must be initialized');
        }

        return $this->container;
    }

    /**
     * Get app.
     *
     * @throws RuntimeException
     *
     * @return App The app
     */
    protected function getApp(): App
    {
        if ($this->app === null) {
            throw new RuntimeException('App must be initialized');
        }

        return $this->app;
    }
}
