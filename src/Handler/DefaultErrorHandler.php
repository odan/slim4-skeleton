<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use DomainException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Selective\Validation\Exception\ValidationException;
use Slim\Exception\HttpException;
use Slim\Views\Twig;
use Throwable;

/**
 * Default Error Renderer.
 */
class DefaultErrorHandler
{
    /**
     * @var Twig
     */
    private $twig;

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
     * @param Twig $twig Twig template engine
     * @param ResponseFactoryInterface $responseFactory The response factory
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        Twig $twig,
        ResponseFactoryInterface $responseFactory,
        LoggerFactory $loggerFactory
    ) {
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->logger = $loggerFactory
            ->addFileHandler('error.log')
            ->createInstance('error');
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

        // Render twig template
        $response = $this->responseFactory->createResponse();
        $response = $this->twig->render(
            $response,
            'error/error.twig',
            [
                'errorMessage' => $errorMessage,
            ]
        );

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
        $statusCode = 500;

        if ($exception instanceof HttpException) {
            $statusCode = (int)$exception->getCode();
        }

        if ($exception instanceof DomainException || $exception instanceof InvalidArgumentException) {
            // Bad request
            $statusCode = 400;
        }

        if ($exception instanceof ValidationException) {
            // Unprocessable Entity
            $statusCode = 422;
        }

        $file = basename($exception->getFile());
        if ($file === 'CallableResolver.php') {
            $statusCode = 404;
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
