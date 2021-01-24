<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Responder\Responder;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Throwable;

/**
 * Default Error Renderer.
 */
final class DefaultErrorHandler
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param ResponseFactoryInterface $responseFactory The response factory
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        Responder $responder,
        ResponseFactoryInterface $responseFactory,
        LoggerFactory $loggerFactory
    ) {
        $this->responder = $responder;
        $this->responseFactory = $responseFactory;
        $this->logger = $loggerFactory
            ->addFileHandler('error.log')
            ->createInstance();
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param Throwable $exception The exception
     * @param bool $displayErrorDetails Show error details
     * @param bool $logErrors Log errors
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors
    ): ResponseInterface {
        // Log error
        if ($logErrors) {
            $this->logger->error(
                sprintf(
                    'Error: [%s] %s, Method: %s, Path: %s',
                    $exception->getCode(),
                    $this->getExceptionText($exception),
                    $request->getMethod(),
                    $request->getUri()->getPath()
                )
            );
        }

        // Detect status code
        $statusCode = $this->getHttpStatusCode($exception);

        // Error message
        $errorMessage = $this->getErrorMessage($exception, $statusCode, $displayErrorDetails);

        // Render response
        $response = $this->responseFactory->createResponse();
        $response = $this->responder->withJson($response, [
            'error' => [
                'message' => $errorMessage,
            ],
        ]);

        return $response->withStatus($statusCode);
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
     * @param int $statusCode The http status code
     * @param bool $displayErrorDetails Display details
     *
     * @return string The message
     */
    private function getErrorMessage(Throwable $exception, int $statusCode, bool $displayErrorDetails): string
    {
        $reasonPhrase = $this->responseFactory->createResponse()->withStatus($statusCode)->getReasonPhrase();
        $errorMessage = sprintf('%s %s', $statusCode, $reasonPhrase);

        if ($displayErrorDetails === true) {
            $errorMessage = sprintf(
                '%s - Error details: %s',
                $errorMessage,
                $this->getExceptionText($exception)
            );
        }

        return $errorMessage;
    }

    /**
     * Get exception text.
     *
     * @param Throwable $exception Error
     * @param int $maxLength The max length of the error message
     *
     * @return string The full error message
     */
    private function getExceptionText(Throwable $exception, int $maxLength = 0): string
    {
        $code = $exception->getCode();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $message = $exception->getMessage();
        $trace = $exception->getTraceAsString();
        $error = sprintf('[%s] %s in %s on line %s.', $code, $message, $file, $line);
        $error .= sprintf("\nBacktrace:\n%s", $trace);

        if ($maxLength > 0) {
            $error = substr($error, 0, $maxLength);
        }

        return $error;
    }
}
