<?php

namespace App\Test\TestCase\Factory;

use App\Factory\LoggerFactory;
use App\Test\Traits\AppTestTrait;
use DateTimeImmutable;
use Monolog\Handler\TestHandler;
use Monolog\Level;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class LoggerFactoryTest extends TestCase
{
    use AppTestTrait;

    private string $temp = '';

    /**
     * Set up.
     */
    public function setUp(): void
    {
        $this->temp = vfsStream::setup()->url();
    }

    /**
     * Test.
     */
    public function test(): void
    {
        $this->expectOutputRegex('/INFO: Info message/');
        $this->expectOutputRegex('/ERROR: Error message/');

        $factory = new LoggerFactory(Level::Debug, $this->temp);

        $testHandler = new TestHandler();
        $factory
            ->addHandler($testHandler)
            ->addFileHandler('test.log')
            ->addConsoleHandler();

        $logger = $factory->createLogger();
        $logger->info('Info message');
        $logger->error('Error message');

        $this->assertTrue($testHandler->hasInfo('Info message'));
        $this->assertTrue($testHandler->hasError('Error message'));

        $now = (new DateTimeImmutable())->format('Y-m-d');
        $this->assertFileExists(sprintf('%s/test-%s.log', $this->temp, $now));
    }
}
