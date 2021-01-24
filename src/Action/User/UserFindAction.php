<?php

namespace App\Action\User;

use App\Domain\User\Service\UserFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserFindAction
{
    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var Responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param UserFinder $userIndex The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(UserFinder $userIndex, Responder $responder)
    {
        $this->userFinder = $userIndex;
        $this->responder = $responder;
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
        $params = (array)$request->getQueryParams();

        $viewData = [
            'users' => $this->userFinder->findUsers($params),
        ];

        return $this->responder->withJson($response, $viewData);
    }
}
