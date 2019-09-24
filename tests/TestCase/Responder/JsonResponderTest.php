<?php

namespace App\Test\TestCase\Responder;

use App\Responder\JsonResponder;
use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;
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
        $actual = $responder->render(['value' => 'abc123ÿ']);

        static::assertSame('{"value":"abc123\u00ff"}', (string)$actual->getBody());
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
        $responder->render(['value' => "\x00\x81"]);
    }
}
