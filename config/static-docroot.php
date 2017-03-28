<?php

/**
 * statically render the realpath of the DOCUMENT_ROOT into vendor/autoload.php
 * to prevent realpath cache
 */

$setenv = function ($name, $value = null) {
    // If PHP is running as an Apache module and an existing
    // Apache environment variable exists, overwrite it
    if (function_exists('apache_getenv') && function_exists('apache_setenv') && apache_getenv($name)) {
        apache_setenv($name, $value);
    }

    if (function_exists('putenv')) {
        putenv("$name=$value");
    }

    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
};

// Statically set DOCUMENT_ROOT to the realpath of the current release.
// This is to prevent symlink related realpath cache issues (using an old
// release, although a new one is available) and prevents using files
// from different releases during one request.
$setenv('DOCUMENT_ROOT', dirname(__DIR__) . '/web');
$setenv('SCRIPT_FILENAME', dirname(__DIR__) . '/web' . $_SERVER['SCRIPT_NAME']);
unset($setenv);
