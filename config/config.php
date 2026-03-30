<?php
define('ROOT_PATH', dirname(__DIR__));

// Dynamic BASE_URL calculation
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$base_dir = dirname($script_name);
if ($base_dir === '/' || $base_dir === '\\') {
    $base_dir = '';
} else {
    $base_dir = str_replace('\\', '/', $base_dir);
}
$base_url = $protocol . "://" . $host . $base_dir;
define('BASE_URL', rtrim($base_url, '/'));

spl_autoload_register(function ($class_name) {
    $paths = [
        ROOT_PATH . '/models/',
        ROOT_PATH . '/controllers/',
        ROOT_PATH . '/utils/',
        ROOT_PATH . '/config/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once ROOT_PATH . '/utils/helpers.php';
?>