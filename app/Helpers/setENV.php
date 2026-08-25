<?php

if (!function_exists('setEnv')) {
    function setEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            // Remove existing quotes
            $value = trim($value, '"');

            // Add quotes ONLY if needed (space or special chars)
            if (preg_match('/\s/', $value)) {
                $value = '"' . $value . '"';
            }

            $env = file_get_contents($path);

            if (strpos($env, $key . '=') !== false) {
                $env = preg_replace(
                    "/^" . preg_quote($key, '/') . "=.*/m",
                    $key . '=' . $value,
                    $env
                );
            } else {
                $env .= "\n{$key}={$value}\n";
            }

            file_put_contents($path, $env);
        }
    }
}
