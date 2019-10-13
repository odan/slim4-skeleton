<?php

namespace App\Action\User;

use App\Domain\User\Service\UserListDataTable;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class UserListDataTableAction
{
    /**
     * @var UserList
     */
    private $userListDataTable;

    /**
     * @var JsonResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param UserListDataTable $userListDataTable The service
     * @param JsonResponder $responder The responder
     */
    public function __construct(
        UserListDataTable $userListDataTable,
        JsonResponder $responder
    ) {
        $this->userListDataTable = $userListDataTable;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param Request $request The request
     *
     * @return Response The response
     */
    public function __invoke(Request $request): Response
    {
        $params = (array)$request->getParsedBody();

        return $this->responder->render($this->userListDataTable->listAllUsers($params));
    }
}
