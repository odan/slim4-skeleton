<?php

namespace App\Test\Traits;

use App\Factory\LoggerFactory;
use Monolog\Handler\TestHandler;
use Monolog\Logger;

/**
 * Test trait.
 */
trait LoggerTestTrait
{
    protected TestHandler $testHandler;

    /**
     * Add test logger.
     *
     * @return void
     */
    protected function setUpLogger(): void
    {
        $this->testHandler = new TestHandler();
        $logger = new Logger('', [$this->testHandler]);

        $loggerFactory = new LoggerFactory(['test' => $logger]);
        $this->setContainerValue(LoggerFactory::class, $loggerFactory);
    }

    /**
     * Get test logger handler.
     *
     * @return TestHandler The logger
     */
    protected function getLogger(): TestHandler
    {
        return $this->testHandler;
    }

    /**
     * Get test logger error messages.
     *
     * @return array The error messages
     */
    protected function getLoggerErrors(): array
    {
        $errors = [];

        foreach ($this->testHandler->getRecords() as $record) {
            if ($record['level_name'] === 'ERROR') {
                $errors[] = $record;
            }
        }

        return $errors;
    }
}
