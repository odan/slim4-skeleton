<?php

namespace App\Test\TestCase;

use Psr\Container\ContainerInterface;
use RuntimeException;
use Slim\App;

/**
 * Container Trait.
 */
trait ContainerTestTrait
{
    /** @var ContainerInterface|null */
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
        $this->container = require __DIR__ . '/../../config/bootstrap.php';
        $this->app = $this->container->get(App::class);
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
     * @return ContainerInterface The container
     */
    protected function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            throw new RuntimeException('Container must be initialized');
        }

        return $this->container;
    }

    /**
     * Get container.
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
