<?php

namespace App\Action\OpenApi;

use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Yaml\Yaml;

final class Version1DocAction
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Path to the yaml file
        $yamlFile = __DIR__ . '/../../../resources/api/example_v1.yaml';

        $viewData = [
            'spec' => json_encode(Yaml::parseFile($yamlFile)),
        ];

        return $this->renderer->template($response, 'doc/swagger.php', $viewData);
    }
}
