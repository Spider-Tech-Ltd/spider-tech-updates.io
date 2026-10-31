<?php
require dirname(__DIR__, 2) . '/config/config.php';
require dirname(__DIR__, 2) . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    
    // Check if show_topbar_banner exists
    $stmt = $db->query("SHOW COLUMNS FROM `training_cohorts` LIKE 'show_topbar_banner'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `training_cohorts` ADD COLUMN `show_topbar_banner` TINYINT(1) NOT NULL DEFAULT 1 AFTER `registration_open`");
        echo "[OK] Added `show_topbar_banner` to `training_cohorts`.\n";
    } else {
        echo "[INFO] `show_topbar_banner` already exists.\n";
    }

    // Check if custom_announcement exists
    $stmt = $db->query("SHOW COLUMNS FROM `training_cohorts` LIKE 'custom_announcement'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `training_cohorts` ADD COLUMN `custom_announcement` VARCHAR(255) NULL AFTER `show_topbar_banner`");
        echo "[OK] Added `custom_announcement` to `training_cohorts`.\n";
    } else {
        echo "[INFO] `custom_announcement` already exists.\n";
    }

    // Make sure existing open cohorts have show_topbar_banner = 1
    $db->exec("UPDATE `training_cohorts` SET `show_topbar_banner` = 1 WHERE `registration_open` = 1");
    echo "[OK] Updated open cohorts to have show_topbar_banner = 1.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
