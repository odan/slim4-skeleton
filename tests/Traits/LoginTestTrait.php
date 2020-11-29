<?php

namespace App\Test\Traits;

use App\Domain\User\Data\UserAuthData;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        $session = $this->container->get(SessionInterface::class);

        if ($session === null) {
            throw new UnexpectedValueException('Session not defined');
        }

        $session->start();
        $session->set('user', $user);
        $session->save();
    }
}
