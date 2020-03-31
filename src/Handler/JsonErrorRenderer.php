<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Utility\ExceptionDetail;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
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
            ->addFileHandler('json_error_renderer.log')
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

        $errorMessage = '500 Internal Server Error';

        if ($exception instanceof HttpException) {
            $errorMessage = sprintf('%s %s', $exception->getCode(), $exception->getMessage());
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
