<?php

namespace App\Action\User;

use App\Responder\HtmlResponder;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Action.
 */
final class UserListAction
{
    /**
     * @var HtmlResponder
     */
    private $responder;

    /**
     * Constructor.
     *
     * @param HtmlResponder $responder The responder
     */
    public function __construct(HtmlResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @return Response The response
     */
    public function __invoke(): Response
    {
        return $this->responder->render('user/user-list.twig');
    }
}
