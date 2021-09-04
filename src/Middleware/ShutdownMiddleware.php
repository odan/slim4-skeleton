<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware.
 */
final class ShutdownMiddleware implements MiddlewareInterface
{
    private bool $displayErrorDetails;

    /**
     * The constructor.
     *
     * @param bool $displayErrorDetails Enable error details
     */
    public function __construct(bool $displayErrorDetails = false)
    {
        $this->displayErrorDetails = $displayErrorDetails;
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $shutdown = function () {
            $error = error_get_last();

            if (!$error) {
                return;
            }

            $message = 'An internal error has occurred while processing your request.';

            if ($this->displayErrorDetails) {
                $message = sprintf(
                    '%s: %s in file %s on line %s.',
                    $this->getErrorTypeTitle($error['type']),
                    $error['message'],
                    $error['file'],
                    $error['line']
                );
            }

            http_response_code(500);
            header('Content-Type: application/json');
            header('Connection: close');

            echo json_encode(
                [
                    'error' => [
                        'message' => $message,
                    ],
                ],
                JSON_PRETTY_PRINT
            );
        };

        // Disable html output to prevent output buffer issues
        error_reporting(0);

        register_shutdown_function($shutdown);

        return $handler->handle($request);
    }

    /**
     * Get error type title.
     *
     * @param int $type The type
     *
     * @return string The title;
     */
    private function getErrorTypeTitle(int $type): string
    {
        switch ($type) {
            case E_USER_ERROR:
                return 'FATAL ERROR';
            case E_USER_WARNING:
                return 'WARNING';
            case E_USER_NOTICE:
                return 'NOTICE';
            default:
                return 'ERROR';
        }
    }
}
