<?php

namespace App\Test\TestCase\Factory;

use App\Factory\LoggerFactory;
use App\Test\Traits\AppTestTrait;
use DateTimeImmutable;
use Monolog\Handler\TestHandler;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class LoggerFactoryTest extends TestCase
{
    use AppTestTrait;

    private string $temp = __DIR__ . '/temp';

    /**
     * Set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        if (!file_exists($this->temp)) {
            mkdir($this->temp);
        }

        $this->cleanUp();
    }

    /**
     * Tear down.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->cleanUp();

        if (file_exists($this->temp)) {
            rmdir($this->temp);
        }
    }

    /**
     * Clean up.
     *
     * @return void
     */
    private function cleanUp(): void
    {
        /** @var array<int, string> $files */
        $files = glob($this->temp . '/*.*');

        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * Test.
     *
     * @return void
     */
    public function test(): void
    {
        $this->expectOutputRegex('/INFO: Info message/');
        $this->expectOutputRegex('/ERROR: Error message/');

        $settings = [
            'path' => $this->temp,
            'level' => 0,
        ];

        $factory = new LoggerFactory($settings);

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
