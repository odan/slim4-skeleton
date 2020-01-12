<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Utility\ExceptionDetail;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

/**
 * JSON Error Renderer.
 */
class JsonErrorRenderer implements ErrorRendererInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
            ->addFileHandler('json_error.log')
            ->createInstance('json_error_renderer');
    }

    /**
     * Invoke.
     *
     * @param Throwable $exception The exception
     * @param bool $displayErrorDetails Show error details
     *
     * @return string The result
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $detailedErrorMessage = ExceptionDetail::getExceptionText($exception);

        // Add error log entry
        $this->logger->error($detailedErrorMessage);

        // Detect error type
        if ($exception instanceof HttpNotFoundException) {
            $errorMessage = '404 Not Found';
        } elseif ($exception instanceof HttpMethodNotAllowedException) {
            $errorMessage = '405 Method Not Allowed';
        } else {
            $errorMessage = '500 Internal Server Error';
        }

        $result = [
            'error' => [
                'message' => $errorMessage,
            ],
        ];

        if ($displayErrorDetails) {
            $result['error']['trace'] = $detailedErrorMessage;
        }

        return (string)json_encode($result);
    }
}
