<?php
/**
 * Middleware for Session Management
 * Ensures authentication for restricted routes.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if a member is currently logged in
 * Uses 'user_id' for legacy compatibility or 'member_uuid'.
 */
function isLoggedIn() {
    return (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ||
           (isset($_SESSION['member_uuid']) && !empty($_SESSION['member_uuid']));
}

/**
 * Require authentication for private routes.
 */
function requireAuth($redirectPath = 'pages/forum/sign-in.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectPath");
        die();
    }
}
