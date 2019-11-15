<?php

namespace App\Action\Home;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;

/**
 * Action.
 */
final class HomeAction
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
     * @return Response The response
     */
    public function __invoke(ServerRequest $request, Response $response): Response
    {
        $viewData = [
            'now' => date('d.m.Y H:i:s'),
        ];

        return $this->twig->render($response, 'home/home.twig', $viewData);
    }
}
