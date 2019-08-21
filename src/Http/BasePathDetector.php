<?php

namespace App\Http;

/**
 * A URL base path detector.
 */
class BasePathDetector
{
    /**
     * @var array The server data
     */
    private $server = [];

    /**
     * The constructor.
     *
     * @param array $server The SERVER data to use
     */
    public function __construct(array $server)
    {
        $this->server = $server;
    }

    /**
     * Calculate the url base path.
     *
     * @return string The base path
     */
    public function getBasePath(): string
    {
        // For built-in server
        if (PHP_SAPI === 'cli-server') {
            return $this->getBasePathFromBuiltIn($this->server);
        }

        // For apache
        return $this->getBasePathFromApache($this->server);
    }

    /**
     * Return basePath for built-in server.
     *
     * @param array $server The SERVER data to use
     *
     * @return string The base path
     */
    private function getBasePathFromBuiltIn(array $server): string
    {
        $scriptName = $server['SCRIPT_NAME'];
        $basePath = str_replace('\\', '/', dirname($scriptName));

        if (strlen($basePath) > 1) {
            return $basePath;
        }

        return '';
    }

    /**
     * Return basePath for apache server.
     *
     * @param array $server The SERVER data to use
     *
     * @return string The base path
     */
    private function getBasePathFromApache(array $server): string
    {
        if (!isset($server['REQUEST_URI'])) {
            return '';
        }

        $scriptName = $server['SCRIPT_NAME'];

        $basePath = (string)parse_url($server['REQUEST_URI'], PHP_URL_PATH);
        $scriptName = str_replace('\\', '/', dirname(dirname($scriptName)));

        if ($scriptName === '/') {
            return '';
        }

        $length = strlen($scriptName);
        if ($length > 0 && $scriptName !== '/') {
            $basePath = substr($basePath, 0, $length);
        }

        if (strlen($basePath) > 1) {
            return $basePath;
        }

        return '';
    }
}
