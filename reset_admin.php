<?php
require_once "config/config.php";
require_once "config/database.php";

try {
    $database = new Database();
    $db = $database->getConnection();

    if ($db === null) {
        die("Critical: Database connection failed.");
    }

    echo "--- Spider Tech System Upgrade & Recovery ---\n";

    // 1. Fix column lengths for passwords and media paths
    echo "Expanding column lengths... ";
    $queries = [
        "ALTER TABLE admin_tb MODIFY COLUMN admin_password VARCHAR(255)",
        "ALTER TABLE projects_tb MODIFY COLUMN project_pic VARCHAR(255)",
        "ALTER TABLE banners_tb MODIFY COLUMN banner_image VARCHAR(255)",
        "ALTER TABLE trainings_tb MODIFY COLUMN training_image VARCHAR(255)",
        "ALTER TABLE events MODIFY COLUMN event_img VARCHAR(255)",
        "ALTER TABLE testimonials_tb MODIFY COLUMN image VARCHAR(255)",
        "ALTER TABLE services_tb MODIFY COLUMN service_icon VARCHAR(255)"
    ];
    foreach ($queries as $q) {
        $db->exec($q);
    }
    echo "Done.\n";

    // 2. Reset Admin Password
    $newPassword = 'admin'; // Change this after login
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    echo "Resetting 'admin' account... ";
    $stmt = $db->prepare("UPDATE admin_tb SET admin_password = ? WHERE admin_name = 'admin'");
    $stmt->execute([$hash]);

    if ($stmt->rowCount() == 0) {
        $stmt = $db->prepare("INSERT INTO admin_tb (admin_name, admin_password, privilege, lastlogin) VALUES ('admin', ?, 'Super Admin', NOW())");
        $stmt->execute([$hash]);
        echo "Admin created. ";
    } else {
        echo "Admin reset. ";
    }
    echo "Done.\n";

    echo "\nUpgrade Complete!\n";
    echo "Login: admin / $newPassword\n";
    echo "IMPORTANT: Delete this file (reset_admin.php) immediately.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
