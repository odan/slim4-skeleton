<?php

namespace App\Action\User;

use App\Domain\User\Data\UserData;
use App\Domain\User\Service\UserReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserReadAction
{
    private UserReader $userReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param UserReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(UserReader $userViewer, Responder $responder)
    {
        $this->userReader = $userViewer;
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
        $user = $this->userReader->getUserData($userId);

        // Transform result
        return $this->transform($response, $user);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param UserData $user The user
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, UserData $user): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $user->id,
            'username' => $user->username,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
            'user_role_id' => $user->userRoleId,
            'locale' => $user->locale,
            'enabled' => $user->enabled,
        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->responder->withJson($response, $data);
    }
}
