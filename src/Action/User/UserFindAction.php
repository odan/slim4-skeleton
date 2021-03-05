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
    private UserFinder $userFinder;

    private Responder $responder;

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

        $users = $this->userFinder->findUsers($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $userList = [];
        foreach ($users as $user) {
            $userList[] = [
                'id' => $user->id,
                'username' => $user->username,
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'email' => $user->email,
                'user_role_id' => $user->userRoleId,
                'locale' => $user->locale,
                'enabled' => $user->enabled,
            ];
        }

        return $this->responder->withJson($response, [
            'users' => $userList,
        ]);
    }
}
