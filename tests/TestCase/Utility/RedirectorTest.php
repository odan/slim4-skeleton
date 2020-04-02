<?php

namespace App\Test\TestCase\Utility;

use App\Test\TestCase\HttpTestTrait;
use App\Utility\Redirector;
use PHPUnit\Framework\TestCase;
use Selective\SlimHelper\Test\Action\RedirectForAction;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;

/**
 * Test.
 */
class RedirectorTest extends TestCase
{
    use HttpTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testRedirectUrl(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = Redirector::redirect($request, new Response(), 'https://www.example.com/');

        static::assertSame(302, $response->getStatusCode());
        static::assertSame('https://www.example.com/', $response->getHeaderLine('Location'));
        static::assertSame('', (string)$response->getBody());
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testRedirectRouteName(): void
    {
        $app = $this->getApp();
        $app->get('/foo', function ($request, $response) {
            return Redirector::redirect($request, $response, 'foo');
        })->setName('foo');

        $request = $this->createRequest('GET', '/foo');
        $response = $app->handle($request);

        static::assertSame(302, $response->getStatusCode());
        static::assertSame('/foo', $response->getHeaderLine('Location'));
        static::assertSame('', (string)$response->getBody());
    }
}
