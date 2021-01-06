<?php

namespace App\Test\Traits;

use App\Domain\User\Data\UserAuthData;
use Odan\Session\SessionInterface;

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

        /** @var SessionInterface $session */
        $session = $this->getSession();
        $session->start();
        $session->set('user', $user);
        $session->save();
    }
}
