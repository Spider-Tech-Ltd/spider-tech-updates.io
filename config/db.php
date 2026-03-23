<?php
/**
 * Database Connection Configuration
 * Uses PDO for secure database interactions.
 */

$host = 'localhost';
$db_name = 'spider_tech_updated_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // In production, log error instead of displaying
    error_log("Connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

return $conn;
