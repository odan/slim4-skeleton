<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final class ValidationExceptionMiddleware implements MiddlewareInterface
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
        } catch (ValidationFailedException $exception) {
            $response = $this->responseFactory->createResponse();
            $data = $this->transform($exception);
            $json = (string)json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $response->getBody()->write($json);

            return $response
                ->withStatus(422)
                ->withHeader('Content-Type', 'application/json');
        }
    }

    private function transform(ValidationFailedException $exception): array
    {
        $error = [];
        $violations = $exception->getViolations();

        if ($exception->getValue()) {
            $error['message'] = $exception->getValue();
        }

        if ($violations->count()) {
            $details = [];

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $details[] = [
                    'message' => $violation->getMessage(),
                    'field' => $violation->getPropertyPath(),
                ];
            }

            $error['details'] = $details;
        }

        return ['error' => $error];
    }
}
