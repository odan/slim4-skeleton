<?php

namespace App\Action;

use App\Responder\HtmlResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class UserIndexAction
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
     * @param Request $request The request
     *
     * @return Response The response
     */
    public function __invoke(Request $request): Response
    {
        return $this->responder->render('user/user-index.twig');
    }
}
