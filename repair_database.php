<?php
/**
 * Spider Tech - Critical Database Repair & CMS Synchronization Tool
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

header('Content-Type: text/html; charset=utf-8');

try {
    $db = (new Database())->getConnection();
    if (!$db) throw new Exception("Could not connect to database.");

    echo "<h2>Spider Tech Database Repair Tool</h2>";
    echo "<ul style='font-family: monospace; font-size: 14px;'>";

    $contentTables = [
        'services_tb' => 'id',
        'projects_tb' => 'project_id',
        'events' => 'event_id',
        'trainings_tb' => 'id'
    ];

    foreach ($contentTables as $table => $pk) {
        echo "<li>Processing table: <strong>$table</strong>... ";

        // 1. Add show_on_home
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'show_on_home'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN show_on_home TINYINT(1) DEFAULT 1");
            echo "<span style='color:blue;'>[Added show_on_home]</span> ";
        } else {
            $db->exec("UPDATE $table SET show_on_home = 1 WHERE show_on_home IS NULL");
        }

        // 2. Add sort_order
        $stmt = $db->query("SHOW COLUMNS FROM $table LIKE 'sort_order'");
        if ($stmt->rowCount() == 0) {
            $db->exec("ALTER TABLE $table ADD COLUMN sort_order INT DEFAULT 0");
            echo "<span style='color:blue;'>[Added sort_order]</span> ";
        }

        echo "OK</li>";
    }

    echo "<li>Expanding column lengths for media... ";
    $db->exec("ALTER TABLE projects_tb MODIFY COLUMN project_pic VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE services_tb MODIFY COLUMN service_icon VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE events MODIFY COLUMN event_img VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE trainings_tb MODIFY COLUMN training_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE banners_tb MODIFY COLUMN banner_image VARCHAR(255) NOT NULL");
    $db->exec("ALTER TABLE admin_tb MODIFY COLUMN admin_password VARCHAR(255) NOT NULL");
    echo "OK</li>";

    echo "<li>Ensuring members table consistency... ";
    $stmt = $db->query("SHOW COLUMNS FROM members LIKE 'status'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE members ADD COLUMN status ENUM('Active', 'Suspended') DEFAULT 'Active' AFTER is_verified");
        echo "[Added status] ";
    }
    echo "OK</li>";

    echo "</ul>";
    echo "<h3 style='color:green;'>Repair Completed Successfully!</h3>";
    echo "<p><strong>Important:</strong> Please delete this file (<code>repair_database.php</code>) immediately for security.</p>";
    echo "<p><a href='" . BASE_URL . "/admin/dashboard'>Go to Dashboard</a></p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Repair Failed:</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
