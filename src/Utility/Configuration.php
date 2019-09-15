<?php

namespace App\Utility;

/**
 * Application Configuration.
 */
class Configuration
{
    /**
     * @var array
     */
    private $configuration = [];

    /**
     * The constructor.
     *
     * @param array $configuration The configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Read configuration.
     *
     * @param string $key The key
     *
     * @return mixed The value
     */
    public function get(string $key)
    {
        return $this->configuration[$key];
    }

    /**
     * Read configuration.
     *
     * @return mixed The configuration
     */
    public function all()
    {
        return $this->configuration;
    }
}
