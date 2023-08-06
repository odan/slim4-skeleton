<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;

final class JsonRenderer
{
    /**
     * Write JSON to the response body.
     *
     * This method prepares the response object to return an HTTP JSON
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param mixed $data The data
     *
     * @return ResponseInterface The response
     */
    public function json(
        ResponseInterface $response,
        mixed $data = null,
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(
            (string)json_encode(
                $data,
                JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR
            )
        );

        return $response;
    }
}
