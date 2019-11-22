<?php

namespace App\Handler;

use App\Factory\LoggerFactory;
use App\Utility\ExceptionDetail;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Http\ServerRequest;
use Slim\Psr7\Response;
use Throwable;

/**
 * Default error handler.
 */
class DefaultErrorHandler
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
            ->addFileHandler('error.log')
            ->createInstance('error_handler');
    }

    /**
     * Invoke the handler.
     *
     * @param ServerRequest $request The request
     * @param Throwable $exception The exception
     * @param bool $displayErrorDetail Show error details
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequest $request,
        Throwable $exception,
        bool $displayErrorDetail
    ): ResponseInterface {
        $response = new Response();

        // Add error log entry
        $detailedErrorMessage = ExceptionDetail::getExceptionText($exception);
        $this->logger->error($detailedErrorMessage);

        // Detect error type
        if ($exception instanceof HttpNotFoundException) {
            $errorMessage = '404 Not Found';
            $response = $response->withStatus(404);
        } elseif ($exception instanceof HttpMethodNotAllowedException) {
            $errorMessage = '405 Method Mot Allowed';
            $response = $response->withStatus(405);
        } else {
            $errorMessage = '500 Internal Server Error';
            $response = $response->withStatus(500);
        }

        $accept = $request->getHeaderLine('accept');

        $body = $response->getBody();
        if (strpos($accept, 'application/json') !== false) {
            return $this->createJsonResponse($response, $errorMessage, $detailedErrorMessage, $displayErrorDetail);
        } else {
            $body->write($errorMessage . ($displayErrorDetail ? ' ' . $detailedErrorMessage : ''));
        }

        return $response;
    }

    /**
     * Create JSON response with error message.
     *
     * @param ResponseInterface $response The response
     * @param string $errorMessage The error message
     * @param string $detailedErrorMessage The full error message
     * @param bool $displayErrorDetail Show details
     *
     * @return ResponseInterface The response
     */
    private function createJsonResponse(
        ResponseInterface $response,
        string $errorMessage,
        string $detailedErrorMessage,
        bool $displayErrorDetail
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');

        $result = [
            'error' => [
                'message' => $errorMessage,
            ],
        ];

        if ($displayErrorDetail) {
            $result['error']['trace'] = $detailedErrorMessage;
        }

        $response->getBody()->write((string)json_encode($result));

        return $response;
    }
}
