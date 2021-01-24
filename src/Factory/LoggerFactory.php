<?php

namespace App\Factory;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Factory.
 */
final class LoggerFactory
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $level;

    /**
     * The constructor.
     *
     * @param array<mixed> $settings The settings
     */
    public function __construct(array $settings)
    {
        $this->path = (string)$settings['path'];
        $this->level = (int)$settings['level'];
    }

    /**
     * @var array<mixed> Handler
     */
    private $handler = [];

    /**
     * Build the logger.
     *
     * @param string|null $name The logging channel
     *
     * @return LoggerInterface The logger
     */
    public function createInstance(string $name = null): LoggerInterface
    {
        $logger = new Logger($name ?: uuid_create());

        foreach ($this->handler as $handler) {
            $logger->pushHandler($handler);
        }

        $this->handler = [];

        return $logger;
    }

    /**
     * Add rotating file logger handler.
     *
     * @param string $filename The filename
     * @param int|null $level The level (optional)
     *
     * @return LoggerFactory The logger factory
     */
    public function addFileHandler(string $filename, int $level = null): self
    {
        $filename = sprintf('%s/%s', $this->path, $filename);
        $rotatingFileHandler = new RotatingFileHandler($filename, 0, $level ?? $this->level, true, 0777);

        // The last "true" here tells monolog to remove empty []'s
        $rotatingFileHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->handler[] = $rotatingFileHandler;

        return $this;
    }

    /**
     * Add a console logger.
     *
     * @param int|null $level The level (optional)
     *
     * @return self The instance
     */
    public function addConsoleHandler(int $level = null): self
    {
        $streamHandler = new StreamHandler('php://stdout', $level ?? $this->level);
        $streamHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->handler[] = $streamHandler;

        return $this;
    }
}
