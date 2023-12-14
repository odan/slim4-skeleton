<?php

namespace App\Middleware;

use App\Factory\QueryFactory;
use Cake\Database\Connection;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

/**
 * ACL
 */
class AclMiddleware implements MiddlewareInterface
{

    /**
     * @var QueryFactory
     */
    private QueryFactory $queryFactory;
    /**
     * @var LoggerInterface|null
     */
    protected ?LoggerInterface $logger;

    private const PERMISSION = "permission";
    private const TABLE_NAME = "account_permission";

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
     * @param ServerRequestInterface $request Server Request
     * @param RequestHandlerInterface $handler Request Handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $routeArguments = RouteContext::fromRequest($request)->getRoute()->getArguments();
        if (array_key_exists(self::PERMISSION, $routeArguments)) {
            $user = $request->getAttribute('user');
            if (empty($user)) {
                return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED, "Unauthorized");
            }

            $query = $this->queryFactory->newSelect(self::TABLE_NAME);
            $query->select(["permission"])
                ->andWhere(['username' => $user])
                ->andWhere(['permission' => $routeArguments[self::PERMISSION]]);
            $row = $query->execute()->fetch('assoc');

            if (!$row) {
                return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED, "Unauthorized");
            }
        }

        /* Everything ok, call next middleware. */
        return $response;
    }
}