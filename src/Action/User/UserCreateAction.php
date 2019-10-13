<?php

namespace App\Action\User;

use App\Domain\User\Service\UserForm;
use App\Responder\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class UserCreateAction
{
    /**
     * @var UserForm
     */
    protected $userForm;

    /**
     * @var JsonResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param UserForm $userForm The form
     * @param JsonResponder $responder The responder
     */
    public function __construct(
        UserForm $userForm,
        JsonResponder $responder
    ) {
        $this->responder = $responder;
        $this->userForm = $userForm;
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
        $userId = $this->userForm->createUser((object)$request->getParsedBody());

        return $this->responder->render([
            'success' => true,
            'user_id' => $userId,
        ]);
    }
}
