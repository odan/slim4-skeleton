<?php

namespace App\Action\User;

use App\Domain\User\Service\UserListDataTable;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

/**
 * Action.
 */
final class UserListDataTableAction
{
    /**
     * @var UserListDataTable
     */
    private $userListDataTable;

    /**
     * Constructor.
     *
     * @param UserListDataTable $userListDataTable The service
     */
    public function __construct(UserListDataTable $userListDataTable)
    {
        $this->userListDataTable = $userListDataTable;
    }

    /**
     * Action.
     *
     * @param ServerRequest $request The request
     * @param Response $response The response
     *
     * @return Response The response
     */
    public function __invoke(ServerRequest $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        return $response->withJson($this->userListDataTable->listAllUsers($params));
    }
}
