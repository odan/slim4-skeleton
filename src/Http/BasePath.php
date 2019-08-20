<?php

namespace App\Http;

/**
 * BasePath helper.
 */
class BasePath
{
    /**
     * Calculate the url base path.
     *
     * @param array $server the SERVER data to use
     *
     * @return string The base path
     */
    public static function getBasePath(array $server): string
    {
        // For built-in server
        if (PHP_SAPI === 'cli-server') {
            return static::getBasePathFromBuiltIn($server);
        }

        // For apache
        return static::getBasePathFromApache($server);
    }

    /**
     * Return basePath for built-in server.
     *
     * @param array $server the SERVER data to use
     *
     * @return string The base path
     */
    private static function getBasePathFromBuiltIn(array $server): string
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
     * @param array $server the SERVER data to use
     *
     * @return string The base path
     */
    private static function getBasePathFromApache(array $server): string
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
