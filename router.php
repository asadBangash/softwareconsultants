<?php
/**
 * Local dev router — mirrors .htaccess clean URL rules for PHP built-in server.
 * Usage: php -S localhost:8000 router.php
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';
$root = __DIR__;

// Redirect .html URLs to clean URLs
if (preg_match('/^(.+)\.html$/', $uri, $m)) {
    $clean = $m[1] === '/index' ? '/' : $m[1];
    header('Location: ' . $clean, true, 301);
    exit;
}

$routes = [
    '/' => '/index.html',
    '/home' => '/index.html',
    '/services' => '/services/index.html',
    '/industries' => '/industries/index.html',
];

if (isset($routes[$uri])) {
    serveHtml($root . $routes[$uri]);
    return true;
}

$htmlFile = $root . $uri . '.html';
if (is_file($htmlFile)) {
    serveHtml($htmlFile);
    return true;
}

return false;

function serveHtml(string $file): void
{
    header('Content-Type: text/html; charset=UTF-8');
    readfile($file);
}
