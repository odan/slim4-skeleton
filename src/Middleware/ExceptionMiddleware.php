<?php

namespace App\Middleware;

use App\Renderer\JsonRenderer;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Throwable;

final class ExceptionMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;
    private JsonRenderer $renderer;
    private ?LoggerInterface $logger;
    private bool $displayErrorDetails;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        JsonRenderer $jsonRenderer,
        ?LoggerInterface $logger = null,
        bool $displayErrorDetails = false,
    ) {
        $this->responseFactory = $responseFactory;
        $this->renderer = $jsonRenderer;
        $this->displayErrorDetails = $displayErrorDetails;
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            return $this->render($exception, $request);
        }
    }

    private function render(
        Throwable $exception,
        ServerRequestInterface $request,
    ): ResponseInterface {
        $httpStatusCode = $this->getHttpStatusCode($exception);
        $response = $this->responseFactory->createResponse($httpStatusCode);

        // Log error
        if (isset($this->logger)) {
            $this->logger->error(
                sprintf(
                    '%s;Code %s;File: %s;Line: %s',
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception->getFile(),
                    $exception->getLine()
                ),
                $exception->getTrace()
            );
        }

        // Content negotiation
        if (str_contains($request->getHeaderLine('Accept'), 'application/json')) {
            $response = $response->withAddedHeader('Content-Type', 'application/json');

            // JSON
            return $this->renderJson($exception, $response);
        }

        // HTML
        return $this->renderHtml($response, $exception);
    }

    public function renderJson(Throwable $exception, ResponseInterface $response): ResponseInterface
    {
        $data = [
            'error' => [
                'message' => $exception->getMessage(),
            ],
        ];

        return $this->renderer->json($response, $data);
    }

    public function renderHtml(ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        $response = $response->withHeader('Content-Type', 'text/html');

        $message = sprintf(
            "\n<br>Error %s (%s)\n<br>Message: %s\n<br>",
            $this->html((string)$response->getStatusCode()),
            $this->html($response->getReasonPhrase()),
            $this->html($exception->getMessage()),
        );

        if ($this->displayErrorDetails) {
            $message .= sprintf(
                'File: %s, Line: %s',
                $this->html($exception->getFile()),
                $this->html((string)$exception->getLine())
            );
        }

        $response->getBody()->write($message);

        return $response;
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        $statusCode = StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
        }

        if ($exception instanceof DomainException || $exception instanceof InvalidArgumentException) {
            $statusCode = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        return $statusCode;
    }

    private function html(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
