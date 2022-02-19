<?php

namespace App\Test\TestCase\Renderer;

use App\Renderer\JsonRenderer;
use App\Renderer\RedirectRenderer;
use App\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 */
class RendererTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJson(): void
    {
        /** @var JsonRenderer $renderer */
        $renderer = $this->container->get(JsonRenderer::class);

        $response = $renderer->json($this->createResponse(), ['success' => true]);

        $this->assertSame('{"success":true}', (string)$response->getBody());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testRedirectUrl(): void
    {
        /** @var RedirectRenderer $renderer */
        $renderer = $this->container->get(RedirectRenderer::class);
        $response = $renderer->redirect($this->createResponse(), 'https://www.example.com/');

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('https://www.example.com/', $response->getHeaderLine('Location'));
        $this->assertSame('', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testRedirectUrlWithQueryString(): void
    {
        /** @var RedirectRenderer $renderer */
        $renderer = $this->container->get(RedirectRenderer::class);
        $queryParams = ['foo' => 'bar'];
        $response = $renderer->redirect($this->createResponse(), 'https://www.example.com/', $queryParams);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('https://www.example.com/?foo=bar', $response->getHeaderLine('Location'));
        $this->assertSame('', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testRedirectRouteName(): void
    {
        /** @var RedirectRenderer $renderer */
        $renderer = $this->container->get(RedirectRenderer::class);

        $this->app->get(
            '/foo',
            function ($request, $response) use ($renderer) {
                return $renderer->redirectFor($response, 'foo');
            }
        )->setName('foo');

        $request = $this->createRequest('GET', '/foo');
        $response = $this->app->handle($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/foo', $response->getHeaderLine('Location'));
        $this->assertSame('', (string)$response->getBody());
    }
}
