<?php

namespace App\Action\User;

use App\Domain\User\Service\UserCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserCreateAction
{
    private JsonRenderer $jsonRenderer;

    private UserCreator $userCreator;

    /**
     * The constructor.
     *
     * @param JsonRenderer $renderer The responder
     * @param UserCreator $userCreator The service
     */
    public function __construct(JsonRenderer $renderer, UserCreator $userCreator)
    {
        $this->jsonRenderer = $renderer;
        $this->userCreator = $userCreator;
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
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createUser($data);

        // Build the HTTP response
        return $this->jsonRenderer
            ->json($response, ['user_id' => $userId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
