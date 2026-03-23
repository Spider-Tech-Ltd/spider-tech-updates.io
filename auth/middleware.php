<?php
/**
 * Middleware for Session Management
 * Ensures authentication for restricted routes.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if a user is currently logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require authentication for private routes.
 * Redirects unauthorized users to the login page.
 */
function requireAuth($redirectPath = 'pages/forum/sign-in.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectPath");
        exit;
    }
}
