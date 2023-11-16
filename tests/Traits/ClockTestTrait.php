<?php

namespace App\Test\Traits;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\MockClock;

/**
 * PSR-20 Test Clock.
 */
trait ClockTestTrait
{
    private function setTestNow(DateTimeImmutable|string $now = 'now', DateTimeZone|string $timezone = null): void
    {
        $this->container->set(ClockInterface::class, new MockClock($now, $timezone));
    }
}
