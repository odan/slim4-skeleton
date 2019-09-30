<?php

namespace App\Action\User;

use App\Domain\User\UserDataTable;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class DataTableUserAction
{
    /**
     * @var UserDataTable
     */
    private $userDataTable;

    /**
     * @var JsonResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param UserDataTable $userDataTable The service
     * @param JsonResponder $responder The responder
     */
    public function __construct(
        UserDataTable $userDataTable,
        JsonResponder $responder
    ) {
        $this->userDataTable = $userDataTable;
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

        return $this->responder->render($this->userDataTable->getDataTable($params));
    }
}
