<?php

namespace App\Action\Home;

use App\Responder\HtmlResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class HomeAction
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
     * @return Response The new response
     */
    public function __invoke(): Response
    {
        $viewData = [
            'now' => date('d.m.Y H:i:s'),
        ];

        return $this->responder->render('home/home.twig', $viewData);
    }
}
