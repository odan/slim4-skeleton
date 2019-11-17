<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;

/**
 * Action.
 */
final class UserListAction
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * The constructor.
     *
     * @param Twig $twig The twig engine
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Action.
     *
     * @param ServerRequest $request The request
     * @param Response $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->twig->render($response, 'user/user-list.twig');
    }
}
