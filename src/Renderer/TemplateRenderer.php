<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

/**
 * A HTML template renderer.
 */
final class TemplateRenderer
{
    private PhpRenderer $phpRenderer;

    /**
     * The constructor.
     *
     * @param PhpRenderer $phpRenderer The template engine
     */
    public function __construct(PhpRenderer $phpRenderer)
    {
        $this->phpRenderer = $phpRenderer;
    }

    /**
     * Output rendered template.
     *
     * @param ResponseInterface $response The response
     * @param string $template Template pathname relative to templates directory
     * @param array $data Associative array of template variables
     *
     * @return ResponseInterface The response
     */
    public function template(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        return $this->phpRenderer->render($response, $template, $data);
    }
}
