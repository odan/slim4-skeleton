<?php

namespace App\Test\TestCase\Domain;

use App\Test\TestCase\UnitTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class ExampleTest extends TestCase
{
    use UnitTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testTrue(): void
    {
        self::assertTrue(true);
    }
}
