<?php

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_production = ($host !== 'localhost' && $host !== '127.0.0.1');

if ($is_production) {
    error_reporting(0);
    ini_set('display_errors', 0);
    // Use the real company email details here later
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

define('ROOT_PATH', dirname(__DIR__));

// Load Environment Configuration
require_once ROOT_PATH . '/utils/Env.php';
Env::load(ROOT_PATH . '/.env');

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

// Mailtrap SMTP Configuration
define('MAIL_HOST', 'sandbox.smtp.mailtrap.io');
define('MAIL_AUTH', true);
define('MAIL_PORT', 2525);
define('MAIL_USER', '1e796e8adea86b');
define('MAIL_PASS', '3e79bc99858c8c');
define('MAIL_ENCRYPTION', 'tls');

// Default Sender Info
define('MAIL_FROM_ADDRESS', 'no-reply@yourcompany.com');
define('MAIL_FROM_NAME', 'Membership Portal');

// Central Company & Invoice Issuer Details
define('INVOICE_COMPANY_NAME', Env::get('INVOICE_COMPANY_NAME', 'Spider Technologies Limited'));
define('INVOICE_COMPANY_ADDRESS', Env::get('INVOICE_COMPANY_ADDRESS', 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano'));
define('INVOICE_COMPANY_EMAIL', Env::get('INVOICE_COMPANY_EMAIL', 'info@spidertech.com.ng'));
define('INVOICE_COMPANY_PHONE', Env::get('INVOICE_COMPANY_PHONE', '+234 911 626 5708'));
define('INVOICE_COMPANY_WEBSITE', Env::get('INVOICE_COMPANY_WEBSITE', 'www.spidertech.com.ng'));

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
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}
