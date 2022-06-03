<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Renderer\JsonRenderer;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

/**
 * Default Error Renderer.
 */
final class DefaultErrorHandler implements ErrorHandlerInterface
{
    private JsonRenderer $jsonRenderer;

    private ResponseFactoryInterface $responseFactory;

    private LoggerInterface $logger;

    public function __construct(
        JsonRenderer $jsonRenderer,
        ResponseFactoryInterface $responseFactory,
        LoggerFactory $loggerFactory
    ) {
        $this->jsonRenderer = $jsonRenderer;
        $this->responseFactory = $responseFactory;
        $this->logger = $loggerFactory
            ->addFileHandler('error.log')
            ->createLogger();
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param Throwable $exception The exception
     * @param bool $displayErrorDetails Show error details
     * @param bool $logErrors Log errors
     * @param bool $logErrorDetails Log error details
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        // Log error
        if ($logErrors) {
            $error = $this->getErrorDetails($exception, $logErrorDetails);
            $error['method'] = $request->getMethod();
            $error['url'] = (string)$request->getUri();

            $this->logger->error($exception->getMessage(), $error);
        }

        $response = $this->responseFactory->createResponse();

        // Render response
        $response = $this->jsonRenderer->json($response, [
            'error' => $this->getErrorDetails($exception, $displayErrorDetails),
        ]);

        return $response->withStatus($this->getHttpStatusCode($exception));
    }

    /**
     * Get http status code.
     *
     * @param Throwable $exception The exception
     *
     * @return int The http code
     */
    private function getHttpStatusCode(Throwable $exception): int
    {
        // Detect status code
        $statusCode = StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpException) {
            $statusCode = (int)$exception->getCode();
        }

        if ($exception instanceof DomainException || $exception instanceof InvalidArgumentException) {
            // Bad request
            $statusCode = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        $file = basename($exception->getFile());
        if ($file === 'CallableResolver.php') {
            $statusCode = StatusCodeInterface::STATUS_NOT_FOUND;
        }

        return $statusCode;
    }

    /**
     * Get error message.
     *
     * @param Throwable $exception The error
     * @param bool $displayErrorDetails Display details
     *
     * @return array The error details
     */
    private function getErrorDetails(Throwable $exception, bool $displayErrorDetails): array
    {
        if ($displayErrorDetails === true) {
            return [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'previous' => $exception->getPrevious(),
                'trace' => $exception->getTrace(),
            ];
        }

        return [
            'message' => $exception->getMessage(),
        ];
    }
}
