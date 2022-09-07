<?php

namespace App\Test\Traits;

use App\Factory\LoggerFactory;
use Monolog\Handler\TestHandler;
use Monolog\Level;
use Monolog\LogRecord;
use UnexpectedValueException;

trait LoggerTestTrait
{
    protected TestHandler $testHandler;

    protected function setUpLogger(): void
    {
        $loggerFactory = $this->container->get(LoggerFactory::class);
        $handlers = $loggerFactory->getTestLogger()->getHandlers();

        foreach ($handlers as $handler) {
            if ($handler instanceof TestHandler) {
                $this->testHandler = $handler;

                return;
            }
        }

        throw new UnexpectedValueException('The monolog test handler is not configured');
    }

    protected function getLogger(): TestHandler
    {
        return $this->testHandler;
    }

    /**
     * @return array<LogRecord>
     */
    protected function getLoggerErrors(): array
    {
        $errors = [];

        foreach ($this->testHandler->getRecords() as $record) {
            if ($record->level === Level::Error) {
                $errors[] = $record;
            }
        }

        return $errors;
    }
}
