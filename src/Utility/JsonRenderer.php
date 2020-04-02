<?php

namespace App\Utility;

use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

/**
 * Json response helper.
 */
final class JsonRenderer
{
    /**
     * Write JSON to Response Body.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * This method prepares the response object to return an HTTP Json
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param mixed $data The data
     * @param int $options Json encoding options
     * @param int $depth Json encoding max depth
     *
     * @throws UnexpectedValueException
     *
     * @return ResponseInterface The response
     */
    public static function encodeJson(
        ResponseInterface $response,
        $data,
        int $options = 0,
        int $depth = 512
    ): ResponseInterface {
        $json = (string)json_encode($data, $options, $depth);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new UnexpectedValueException(json_last_error_msg(), json_last_error());
        }

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($json);

        return $response;
    }
}
