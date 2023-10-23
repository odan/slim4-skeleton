<?php

namespace App\Middleware;

use App\Support\Validation\ValidationException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ValidationMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            $response = $this->responseFactory->createResponse();
            $data = $this->transform($exception);
            $json = (string)json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
            $response->getBody()->write($json);

            return $response
                ->withStatus(422)
                ->withHeader('Content-Type', 'application/json');
        }
    }

    private function transform(ValidationException $exception): array
    {
        $error = [
            'message' => $exception->getMessage(),
        ];

        $errors = $exception->getValidationResult()?->getErrors();

        if ($errors) {
            $error['details'] = [];
            foreach ($errors as $field => $message) {
                $error['details'][] = [
                    'message' => $message,
                    'field' => $field,
                ];
            }
        }

        return ['error' => $error];
    }
}
