<?php

namespace App\Action\User;

use App\Domain\User\Service\UserDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserDeleteAction
{
    private UserDeleter $userDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param UserDeleter $userDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(UserDeleter $userDeleter, Responder $responder)
    {
        $this->userDeleter = $userDeleter;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = (int)$args['user_id'];

        // Invoke the domain (service class)
        $this->userDeleter->deleteUser($userId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
