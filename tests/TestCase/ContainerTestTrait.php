<?php

namespace App\Test\TestCase;

use RuntimeException;
use Slim\App;

/**
 * Container Trait.
 */
trait ContainerTestTrait
{
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
    }

    /**
     * Shutdown app.
     *
     * @return void
     */
    protected function shutdownApp(): void
    {
        $this->app = null;
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
            throw new RuntimeException('Container must be initialized');
        }

        return $this->app;
    }
}
