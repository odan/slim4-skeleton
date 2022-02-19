<?php

namespace App\Action\Home;

use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HomeAction
{
    private RedirectRenderer $redirectRenderer;

    /**
     * The constructor.
     *
     * @param RedirectRenderer $renderer The renderer
     */
    public function __construct(RedirectRenderer $renderer)
    {
        $this->redirectRenderer = $renderer;
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
        return $this->redirectRenderer->redirectFor($response, 'docs');
    }
}
