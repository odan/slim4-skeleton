<?php

namespace App\Test\Traits;

use App\Factory\LoggerFactory;
use Monolog\Handler\NoopHandler;
use Monolog\Logger;

/**
 * Logger Test Trait.
 */
trait LoggerTestTrait
{
    /**
     * Disable logging for testing.
     *
     * @return void
     */
    protected function disableLogger()
    {
        $logger = new Logger('testing');
        $logger->pushHandler(new NoopHandler());

        $factory = new LoggerFactory(
            [
                'path' => '',
                'level' => 0,
                'test' => $logger,
            ]
        );

        // Disable logging for testing
        $this->container->set(LoggerFactory::class, $factory);
    }
}
