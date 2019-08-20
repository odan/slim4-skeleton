<?php

namespace App\Action;

use App\Responder\HtmlResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Action.
 */
final class TimeAction
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
        $viewData = [
            'now' => date('d.m.Y H:i:s'),
        ];

        // Render template
        return $this->responder->render('Time/time-index.twig', $viewData);
    }
}
