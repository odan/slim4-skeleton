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
 * Html Error Renderer.
 */
class HtmlErrorRenderer implements ErrorRendererInterface
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
            ->addFileHandler('html_error.log')
            ->createInstance('html_error_renderer');
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

        if ($displayErrorDetails) {
            return $detailedErrorMessage;
        }

        // Detect error type
        if ($exception instanceof HttpNotFoundException) {
            $errorMessage = '404 Not Found';
        } elseif ($exception instanceof HttpMethodNotAllowedException) {
            $errorMessage = '405 Method Not Allowed';
        } else {
            $errorMessage = '500 Internal Server Error';
        }

        return $errorMessage;
    }
}
