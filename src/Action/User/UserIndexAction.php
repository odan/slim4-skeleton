<?php

namespace App\Action\User;

use App\Domain\User\Service\UserIndex;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserIndexAction
{
    /**
     * @var UserIndex
     */
    private $userIndex;

    /**
     * @var Responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param UserIndex $userIndex The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(UserIndex $userIndex, Responder $responder)
    {
        $this->userIndex = $userIndex;
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
            'users' => $this->userIndex->listUsers($params),
        ];

        return $this->responder->render($response, 'user/user-list.twig', $viewData);
    }
}
