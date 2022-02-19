<?php

namespace App\Action\User;

use App\Domain\User\Service\UserUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserUpdateAction
{
    private JsonRenderer $jsonRenderer;

    private UserUpdater $userUpdater;

    /**
     * The constructor.
     *
     * @param JsonRenderer $jsonRenderer The renderer
     * @param UserUpdater $userUpdater The service
     */
    public function __construct(JsonRenderer $jsonRenderer, UserUpdater $userUpdater)
    {
        $this->jsonRenderer = $jsonRenderer;
        $this->userUpdater = $userUpdater;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $userId = (int)$args['user_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->userUpdater->updateUser($userId, $data);

        // Build the HTTP response
        return $this->jsonRenderer->json($response);
    }
}
