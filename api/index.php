<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Entry point for Vercel's PHP runtime (vercel-php), which sends every request that is
 * not a static file here. A deployment's file system is read-only apart from /tmp, so
 * Laravel's caches and compiled views go there and logs go to Vercel's log stream.
 * Values set in the Vercel project settings win over these defaults.
 *
 * It boots Laravel itself rather than requiring public/index.php, because public/ is
 * served as static files on Vercel and .vercelignore leaves public/index.php out.
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

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
