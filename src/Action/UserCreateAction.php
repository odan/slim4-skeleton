<?php

namespace App\Action;

use App\Domain\User\UserCreator;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class UserCreateAction
{
    /**
     * @var UserCreator
     */
    private $userCreator;

    /**
     * @var JsonResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param UserCreator $userCreator The user service
     * @param JsonResponder $responder The responder
     */
    public function __construct(
        UserCreator $userCreator,
        JsonResponder $responder
    ) {
        $this->userCreator = $userCreator;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * > curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost/users
     *
     * @param Request $request The request
     *
     * @return Response The new response
     */
    public function __invoke(Request $request): Response
    {
        $userData = (array)$request->getParsedBody();

        $userId = $this->userCreator->createUser($userData);

        $result = [
            'success' => true,
            'user_id' => $userId,
        ];

        return $this->responder->render($result);
    }
}
