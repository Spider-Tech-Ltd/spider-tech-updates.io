<?php
/**
 * PHP Built-in Server Router for Playwright Verification
 */

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $url;

if ($url !== '/' && file_exists($file)) {
    return false; // serve the requested resource as-is.
}

$_GET['url'] = ltrim($url, '/');
require_once __DIR__ . '/index.php';
