<?php
/**
 * Logout Logic — Spider Tech Forum
 * Securely destroys session and redirects to sign-in page.
 */

session_start();

// Unset all session variables
$_SESSION = [];

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

header("Location: sign-in.php");
die();
