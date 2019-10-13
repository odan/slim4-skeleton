<?php

namespace App\Responder;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

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
     * @param array|null $data The data
     *
     * @throws UnexpectedValueException
     *
     * @return ResponseInterface
     */
    public function render(array $data = null): ResponseInterface
    {
        $json = json_encode($data);
        if ($json === false) {
            throw new UnexpectedValueException('Malformed UTF-8 characters, possibly incorrectly encoded.');
        }

        $response = $this->responseFactory->createResponse()->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($json);

        return $response;
    }
}
