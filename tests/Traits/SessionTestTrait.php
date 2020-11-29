<?php

namespace App\Test\Traits;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UnexpectedValueException;

/**
 * Session Test Trait.
 */
trait SessionTestTrait
{
    /**
     * Clear session.
     *
     * @throws UnexpectedValueException
     *
     * @return SessionInterface The session
     */
    protected function getSession(): SessionInterface
    {
        $session = $this->container->get(SessionInterface::class);

        if ($session === null) {
            throw new UnexpectedValueException('Session not defined');
        }

        return $session;
    }

    /**
     * Clear session.
     *
     * TestCases must call this method inside tearDown().
     *
     * @return void
     */
    protected function tearDownSession(): void
    {
        $session = $this->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $session->invalidate();
    }
}
