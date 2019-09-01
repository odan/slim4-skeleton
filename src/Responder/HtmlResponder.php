<?php

namespace App\Responder;

use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * A generic HTML Responder.
 */
final class HtmlResponder
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * Constructor.
     *
     * @param ResponseFactoryInterface $responseFactory The response factory
     * @param Twig $twig The twig engine
     */
    public function __construct(ResponseFactoryInterface $responseFactory, Twig $twig)
    {
        $this->responseFactory = $responseFactory;
        $this->twig = $twig;
    }

    /**
     * Render template and return a html response.
     *
     * @return ResponseInterface The response
     */
    public function createResponse(): ResponseInterface
    {
        return $this->responseFactory->createResponse()->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Render template and return a html response.
     *
     * @param string $name The template file
     * @param array $viewData The view data
     *
     * @throws Exception
     *
     * @return ResponseInterface The response
     */
    public function render(string $name, array $viewData = []): ResponseInterface
    {
        return $this->twig->render($this->createResponse(), $name, $viewData);
    }
}
