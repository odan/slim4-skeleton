<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;

/**
 * A JSON response renderer.
 */
final class JsonRenderer
{
    /**
     * Write JSON to the response body.
     *
     * This method prepares the response object to return an HTTP JSON
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param mixed|null $data The data
     * @param int $options Json encoding options
     *
     * @return ResponseInterface The response
     */
    public function json(
        ResponseInterface $response,
        $data = null,
        int $options = 0
    ): ResponseInterface {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string)json_encode($data, $options));

        return $response;
    }
}
