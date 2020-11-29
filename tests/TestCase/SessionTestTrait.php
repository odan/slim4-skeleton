<?php

namespace App\Test\TestCase;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Session Test Trait.
 */
trait SessionTestTrait
{
    /**
     * Clear session.
     *
     * @after
     *
     * @return void
     */
    protected function tearDownSession(): void
    {
        $session = $this->container->get(SessionInterface::class);
        if (!$session->isStarted()) {
            $session->start();
        }
        $session->invalidate();
    }
}
