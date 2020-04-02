<?php

namespace App\Test\TestCase\Utility;

use App\Utility\JsonRenderer;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;

/**
 * Test.
 */
class JsonRendererTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testEncodeJson(): void
    {
        $response = JsonRenderer::encodeJson(new Response(), ['success' => true]);

        static::assertSame('{"success":true}', (string)$response->getBody());
        static::assertSame('application/json', $response->getHeaderLine('Content-Type'));
        static::assertSame(200, $response->getStatusCode());
    }
}
