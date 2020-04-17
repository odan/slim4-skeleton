<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Utility\ExceptionDetail;
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
            $this->logger->error(sprintf(
                'Error: [%s] %s, Method: %s, Path: %s',
                $exception->getCode(),
                ExceptionDetail::getExceptionText($exception),
                $request->getMethod(),
                $request->getUri()->getPath()
            ));
        }

        // Detect status code
        $statusCode = $this->getHttpStatusCode($exception);

        // Error message
        $errorMessage = $this->getErrorMessage($exception, $statusCode, $displayErrorDetails);

        // Render twig template
        $response = $this->responseFactory->createResponse();
        $response = $this->twig->render($response, 'error/error.twig', [
            'errorMessage' => $errorMessage,
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
        // Default error message
        $errorMessage = '500 Internal Server Error';

        if ($statusCode === 403) {
            $errorMessage = '403 Access denied. The user does not have access to this section.';
        } elseif ($statusCode === 404) {
            $errorMessage = '404 Not Found';
        } elseif ($statusCode === 405) {
            $errorMessage = '405 Method Not Allowed';
        } elseif ($statusCode >= 400 && $statusCode <= 499) {
            $errorMessage = sprintf('%s Error', $statusCode);
        }

        if ($displayErrorDetails === true) {
            $errorMessage .= ' - Error details: ' . ExceptionDetail::getExceptionText($exception);
        }

        return $errorMessage;
    }
}
