<?php

namespace App\Action\User;

use App\Domain\User\Service\UserListDataTable;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserListDataTableAction
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * @var UserListDataTable
     */
    private $userListDataTable;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param UserListDataTable $userListDataTable The service
     */
    public function __construct(Responder $responder, UserListDataTable $userListDataTable)
    {
        $this->responder = $responder;
        $this->userListDataTable = $userListDataTable;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = (array)$request->getParsedBody();

        return $this->responder->json($response, $this->userListDataTable->listAllUsers($params));
    }
}
