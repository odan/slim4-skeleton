<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserAuthData;
use App\Domain\User\Repository\UserAuthRepository;
use UnexpectedValueException;

/**
 * User authentication.
 */
final class UserAuth
{
    /**
     * @var UserAuthRepository
     */
    private $repository;

    /**
     * @var UserAuthData|null
     */
    private $user;

    /**
     * The constructor.
     *
     * @param UserAuthRepository $repository The repository
     */
    public function __construct(UserAuthRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Performs an authentication attempt.
     *
     * @param string $username The username
     * @param string $password The password
     *
     * @return UserAuthData|null
     */
    public function authenticate(string $username, string $password): ?UserAuthData
    {
        $userRow = $this->repository->findUserByUsername($username);

        if (!$userRow) {
            return null;
        }

        if (!password_verify($password, (string)$userRow['password'])) {
            return null;
        }

        // Map array to DTO
        $user = new UserAuthData();
        $user->id = (int)$userRow['id'];
        $user->email = (string)$userRow['email'];
        $user->locale = (string)$userRow['locale'];

        return $user;
    }

    /**
     * Set the identity into storage or null if no identity is available.
     *
     * @param UserAuthData|null $user The user
     *
     * @return void
     */
    public function setUser(?UserAuthData $user): void
    {
        $this->user = $user;
    }

    /**
     * Returns the identity from storage or null if no identity is available.
     *
     * @throws UnexpectedValueException
     *
     * @return UserAuthData The user
     */
    public function getUser(): UserAuthData
    {
        if (!$this->user) {
            throw new UnexpectedValueException('No user available');
        }

        return $this->user;
    }
}
