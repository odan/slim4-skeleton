<?php

namespace App\Action\User;

use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Service\UserCreator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

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
     * The constructor.
     *
     * @param UserCreator $userCreator The service
     */
    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    /**
     * Action.
     *
     * > curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost/users
     *
     * @param ServerRequest $request The request
     * @param Response $response The response
     *
     * @return Response The response
     */
    public function __invoke(ServerRequest $request, Response $response): Response
    {
        // Collect input from the HTTP request
        $userData = new UserCreatorData((array)$request->getParsedBody());

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createUser($userData);

        // Build the HTTP response
        return $response->withJson([
            'user_id' => $userId,
        ]);
    }
}
