<?php

/**
 * Lightweight, dependency-free .env file parser for Spider Tech
 */
class Env
{
    private static bool $loaded = false;

    /**
     * Load environment variables from a file into putenv, $_ENV, and $_SERVER
     */
    public static function load(?string $path = null): void
    {
        if (self::$loaded && $path === null) {
            return;
        }

        $envFile = $path ?: (defined('ROOT_PATH') ? ROOT_PATH . '/.env' : dirname(__DIR__) . '/.env');

        if (!file_exists($envFile) || !is_readable($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and empty lines
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            // Split by first equals sign
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Skip invalid variable names
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                    continue;
                }

                // Strip outer quotes if present
                if (
                    (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))
                ) {
                    $value = substr($value, 1, -1);
                } else {
                    // Strip trailing inline comments if unquoted
                    if (($commentPos = strpos($value, ' #')) !== false) {
                        $value = trim(substr($value, 0, $commentPos));
                    }
                }

                // Only set if not already set by system environment
                if (!array_key_exists($key, $_ENV)) {
                    putenv("{$key}={$value}");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }

        self::$loaded = true;
    }

    /**
     * Retrieve an environment variable with optional default
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$loaded) {
            self::load();
        }

        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null) {
            return $default;
        }

        // Normalize common string representations
        $lower = strtolower(trim((string)$value));
        if ($lower === 'true') return true;
        if ($lower === 'false') return false;
        if ($lower === 'null') return null;
        if ($lower === 'empty') return '';

        return $value;
    }
}
