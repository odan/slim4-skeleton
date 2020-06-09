<?php

namespace App\Test;

use App\Domain\User\Data\UserAuthData;
use Symfony\Component\HttpFoundation\Session\Session;
use UnexpectedValueException;

/**
 * Trait.
 */
trait LoginTestTrait
{
    /**
     * Login user.
     *
     * @return void
     */
    private function loginUser(): void
    {
        $user = new UserAuthData();
        $user->id = 1;
        $user->locale = 'en_US';
        $session = $this->container->get(Session::class);

        if ($session === null) {
            throw new UnexpectedValueException('Session not defined');
        }

        $session->set('user', $user);
    }
}
