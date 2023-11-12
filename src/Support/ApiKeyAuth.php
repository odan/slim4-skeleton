<?php

namespace App\Support;

final class ApiKeyAuth
{
    /**
     * @var string The api key
     */
    private string $apiKey;

    /**
     * The constructor.
     *
     * @param string $apiKey The api key as string
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Check if is equal to given api key
     *
     * @param string $apikey received api key
     * @return bool if api keys are equal
     */
    public function validate(string $apikey): bool
    {
        return ($apikey == $this->apiKey);
    }
}
