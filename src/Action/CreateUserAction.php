<?php

namespace App\Action;

use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class CreateUserAction
{
    /**
     * @var JsonResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param JsonResponder $responder The responder
     */
    public function __construct(JsonResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param Request $request The request
     * @param Response $response The response
     * @param array $args The arguments
     *
     * @return Response The new response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = [
            'result' => ['success' => true],
        ];

        return $this->responder->encode($result);
    }
}
