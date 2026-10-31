<?php
/**
 * Migration: Create training_cohorts table and add cohort_id to training_registrations and events
 * Additive and idempotent.
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    echo "Running Migration: Create training_cohorts table...\n";

    // 1. Create training_cohorts table
    $sql = "CREATE TABLE IF NOT EXISTS `training_cohorts` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `training_id` INT NOT NULL,
      `cohort_number` INT NOT NULL,
      `cohort_name` VARCHAR(100) NOT NULL,
      `slug` VARCHAR(120) NOT NULL,
      `start_date` DATE NOT NULL,
      `end_date` DATE NOT NULL,
      `registration_open` TINYINT(1) NOT NULL DEFAULT 0,
      `registration_deadline` DATETIME NULL,
      `capacity` INT NULL DEFAULT 0,
      `status` ENUM('upcoming', 'open', 'ongoing', 'completed') NOT NULL DEFAULT 'upcoming',
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `uk_training_cohort_slug` (`slug`),
      KEY `idx_training_cohort` (`training_id`, `cohort_number`),
      CONSTRAINT `fk_cohort_training` FOREIGN KEY (`training_id`) REFERENCES `trainings_tb` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    $db->exec($sql);
    echo "[OK] `training_cohorts` table ensured.\n";

    // 2. Add cohort_id to training_registrations (nullable)
    $stmt = $db->query("SHOW COLUMNS FROM `training_registrations` LIKE 'cohort_id'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `training_registrations` ADD COLUMN `cohort_id` INT NULL AFTER `program_id`, ADD INDEX `idx_tr_cohort` (`cohort_id`)");
        echo "[OK] Added `cohort_id` to `training_registrations`.\n";
    } else {
        echo "[INFO] `cohort_id` already exists in `training_registrations`.\n";
    }

    // 3. Add cohort_id to events (nullable)
    $stmt = $db->query("SHOW COLUMNS FROM `events` LIKE 'cohort_id'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `events` ADD COLUMN `cohort_id` INT NULL AFTER `event_id`, ADD INDEX `idx_events_cohort` (`cohort_id`)");
        echo "[OK] Added `cohort_id` to `events`.\n";
    } else {
        echo "[INFO] `cohort_id` already exists in `events`.\n";
    }

    echo "\nMigration completed successfully!\n";

} catch (Exception $e) {
    echo "[ERROR] Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
