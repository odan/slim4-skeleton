<?php

namespace App\Action\Home;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HomeAction
{
    private Responder $responder;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
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
        //define('AAAAA', 1);
        //define('AAAAA', 1);
        trigger_error('Fatal error', E_USER_ERROR);

        //trigger_error('XXX', E_USER_NOTICE);
        //   trigger_error('XXX', E_USER_ERROR);
        //trigger_error('XXX', E_USER_WARNING);
        //    throw new \RuntimeException('Test runtime exeption');
        return $this->responder->withRedirectFor($response, 'docs');
    }
}
