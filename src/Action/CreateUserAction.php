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
     * > curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost/users
     *
     * @param Request $request The request
     *
     * @return Response The new response
     */
    public function __invoke(Request $request): Response
    {
        $result = $request->getParsedBody();

        return $this->responder->encode($result);
    }
}
