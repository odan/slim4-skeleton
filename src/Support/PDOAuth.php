<?php

namespace App\Support;

use App\Factory\QueryFactory;
use Cake\Database\Connection;
use Psr\Log\LoggerInterface;
use Tuupola\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

/**
 * PDO HttpBasicAuthentication Interface
 */
class PDOAuth implements AuthenticatorInterface
{
    /**
     * @var QueryFactory
     */
    private QueryFactory $queryFactory;
    /**
     * @var LoggerInterface|null
     */
    protected ?LoggerInterface $logger;

    public static string $TABLE_NAME = "account";
    public static array $MODEL = [
        'id',
        'username',
        'password',
        'email',
        'active',
    ];

    /**
     * @param Connection $connection Connection to DB
     * @param LoggerInterface|null $logger Logger
     */
    public function __construct(Connection $connection, ?LoggerInterface $logger = null)
    {
        $this->queryFactory = new QueryFactory($connection);
        $this->logger = $logger;
    }

    /**
     * @param array $arguments Arguments user/password
     * @return bool
     */
    public function __invoke(array $arguments): bool
    {
        if (empty($arguments['user']) || empty($arguments['password'])) {
            return false;
        }
        $query = $this->queryFactory->newSelect(self::$TABLE_NAME);
        $query->select(["active", "password"])
            ->andWhere(['username' => $arguments['user']]);
        $row = $query->execute()->fetch('assoc');

        if (!$row || !$row['active']) {
            $this->logger->warning("invalid auth attempt: " . $arguments['user']);
            return false;
        }
        return password_verify($arguments['password'], $row['password']);
    }
}