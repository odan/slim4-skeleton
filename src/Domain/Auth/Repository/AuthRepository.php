<?php

namespace App\Domain\Auth\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class AuthRepository
{
    private QueryFactory $queryFactory;

    public static string $TABLE_NAME = "account";

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Validate Username/Password.
     *
     * @param string $username Username
     * @param string $password Password
     * @return bool Is Valid
     */
    public function validate(string $username, string $password): bool
    {
        $query = $this->queryFactory->newSelect($this::$TABLE_NAME);
        $query->select(["active", "password"])
            ->andWhere(['username' => $username]);
        $row = $query->execute()->fetch('assoc');

        if (!$row || !$row['active']) {
            return false;
        }

        return password_verify($password, $row['password']);
    }
}
