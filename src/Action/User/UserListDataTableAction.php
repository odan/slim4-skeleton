<?php

namespace App\Action\User;

use App\Domain\User\Service\UserListDataTable;
use App\Utility\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = (array)$request->getParsedBody();

        return JsonRenderer::encodeJson($response, $this->userListDataTable->listAllUsers($params));
    }
}
