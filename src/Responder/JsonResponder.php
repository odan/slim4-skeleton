<?php

namespace App\Responder;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * A generic JSON responder.
 */
final class JsonResponder
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Constructor.
     *
     * @param ResponseFactoryInterface $responseFactory The response factory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Generate a json response.
     *
     * @param mixed $data The data
     *
     * @throws RuntimeException
     *
     * @return ResponseInterface
     */
    public function encode($data = null): ResponseInterface
    {
        $json = json_encode($data);

        if ($json === false) {
            throw new RuntimeException('Malformed UTF-8 characters, possibly incorrectly encoded.');
        }

        $response = $this->responseFactory->createResponse()->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($json);

        return $response;
    }
}
