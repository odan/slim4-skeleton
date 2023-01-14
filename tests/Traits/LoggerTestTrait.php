<?php

namespace App\Test\Traits;

use App\Factory\LoggerFactory;
use Monolog\Handler\TestHandler;
use Monolog\Level;
use Monolog\LogRecord;

trait LoggerTestTrait
{
    protected TestHandler $testHandler;

    protected function setUpLogger(): void
    {
        $this->testHandler = new TestHandler();

        $settings = [
            // Add only this TestHandler
            'test' => $this->testHandler,
        ];

        $factory = new LoggerFactory($settings);

        $this->setContainerValue(LoggerFactory::class, $factory);
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
