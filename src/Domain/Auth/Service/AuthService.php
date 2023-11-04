<?php

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Repository\AuthRepository;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class AuthService
{
    private AuthRepository $repository;
    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AuthRepository $repository The repository
     * @param LoggerInterface $logger the Logger interface
     */
    public function __construct(AuthRepository $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Validate Username/Password.
     *
     * @param array $data Data
     * @return bool Is Valid
     */
    public function validate(array $data): bool
    {
        // Input validation
        if (empty($data) || empty($data['username']) || empty($data['password'])) {
            return false;
        }

        return $this->repository->validate($data['username'], $data['password']);
    }
}
