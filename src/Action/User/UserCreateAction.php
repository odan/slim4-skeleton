<?php

namespace App\Action\User;

use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Service\UserCreator;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserCreateAction
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * @var UserCreator
     */
    private $userCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param UserCreator $userCreator The service
     */
    public function __construct(Responder $responder, UserCreator $userCreator)
    {
        $this->responder = $responder;
        $this->userCreator = $userCreator;
    }

    /**
     * Action.
     *
     * > curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost/users
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Collect input from the HTTP request
        $userData = new UserCreatorData((array)$request->getParsedBody());

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createUser($userData);

        // Build the HTTP response
        return $this->responder->json($response, [
            'user_id' => $userId,
        ]);
    }
}
