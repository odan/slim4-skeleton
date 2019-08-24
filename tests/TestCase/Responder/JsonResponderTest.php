<?php

namespace App\Test\TestCase\Responder;

use App\Responder\JsonResponder;
use App\Test\TestCase\ContainerTestTrait;
use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Tests.
 */
class JsonResponderTest extends TestCase
{
    use UnitTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testValidEncoding(): void
    {
        $responder = $this->getContainer()->get(JsonResponder::class);
        $actual = $responder->encode('abc123ÿ');

        static::assertSame('"abc123\u00ff"', (string)$actual->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidEncoding(): void
    {
        static::expectException(RuntimeException::class);
        static::expectExceptionMessage('Malformed UTF-8 characters, possibly incorrectly encoded.');

        $responder = $this->getContainer()->get(JsonResponder::class);
        $responder->encode("\x00\x81");
    }
}
