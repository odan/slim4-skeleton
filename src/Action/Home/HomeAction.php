<?php

namespace App\Action\Home;

use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    private RedirectRenderer $redirectRenderer;

    public function __construct(RedirectRenderer $renderer)
    {
        $this->redirectRenderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->redirectRenderer->redirectFor($response, 'docs');
    }
}
