<?php

/**
 * Entry point for Vercel's PHP runtime (vercel-php), which sends every request that is
 * not a static file here. A deployment's file system is read-only apart from /tmp, so
 * Laravel's caches and compiled views go there and logs go to Vercel's log stream.
 * Values set in the Vercel project settings win over these defaults.
 */
$serverlessDefaults = [
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_SECURE_COOKIE' => 'true',
];

foreach ($serverlessDefaults as $name => $value) {
    if (getenv($name) === false) {
        putenv("{$name}={$value}");
        $_ENV[$name] = $_SERVER[$name] = $value;
    }
}

require __DIR__.'/../public/index.php';
