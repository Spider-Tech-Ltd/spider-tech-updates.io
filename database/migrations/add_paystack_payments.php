<?php
/**
 * Migration: Add Paystack Payment Support to Database
 * Safe, idempotent, and non-destructive.
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

try {
    $db = (new Database())->getConnection();
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    echo "Running Migration: Add Paystack Payment Support...\n";

    // 1. Add columns to trainings_tb
    $stmt = $db->query("SHOW COLUMNS FROM `trainings_tb` LIKE 'payments_enabled'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `trainings_tb` ADD COLUMN `payments_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `registration_available`");
        echo "[OK] Added `payments_enabled` to `trainings_tb`.\n";
    } else {
        echo "[INFO] `payments_enabled` already exists in `trainings_tb`.\n";
    }

    $stmt = $db->query("SHOW COLUMNS FROM `trainings_tb` LIKE 'payment_amount'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `trainings_tb` ADD COLUMN `payment_amount` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `payments_enabled`");
        echo "[OK] Added `payment_amount` to `trainings_tb`.\n";
    } else {
        echo "[INFO] `payment_amount` already exists in `trainings_tb`.\n";
    }

    // 2. Add column to training_cohorts
    $stmt = $db->query("SHOW COLUMNS FROM `training_cohorts` LIKE 'payment_amount'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `training_cohorts` ADD COLUMN `payment_amount` INT UNSIGNED NULL DEFAULT NULL AFTER `capacity`");
        echo "[OK] Added `payment_amount` to `training_cohorts`.\n";
    } else {
        echo "[INFO] `payment_amount` already exists in `training_cohorts`.\n";
    }

    // 3. Add columns to training_registrations
    $stmt = $db->query("SHOW COLUMNS FROM `training_registrations` LIKE 'payment_status'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE `training_registrations` 
            ADD COLUMN `payment_status` ENUM('not_required', 'pending', 'success', 'failed', 'abandoned') NOT NULL DEFAULT 'not_required' AFTER `user_data`,
            ADD COLUMN `payment_reference` VARCHAR(100) NULL AFTER `payment_status`,
            ADD COLUMN `amount_paid` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `payment_reference`,
            ADD COLUMN `currency` VARCHAR(10) NOT NULL DEFAULT 'NGN' AFTER `amount_paid`,
            ADD COLUMN `paid_at` DATETIME NULL AFTER `currency`,
            ADD COLUMN `invoice_number` VARCHAR(50) NULL AFTER `paid_at`,
            ADD COLUMN `invoice_sent_at` DATETIME NULL AFTER `invoice_number`,
            ADD UNIQUE KEY `uniq_payment_reference` (`payment_reference`),
            ADD UNIQUE KEY `uniq_invoice_number` (`invoice_number`),
            ADD INDEX `idx_payment_status` (`payment_status`)");
        echo "[OK] Added payment columns to `training_registrations`.\n";
    } else {
        echo "[INFO] `payment_status` already exists in `training_registrations`.\n";
    }

    // 4. Create payment_transactions table
    $sql = "CREATE TABLE IF NOT EXISTS `payment_transactions` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `application_id` INT UNSIGNED NOT NULL,
        `program_id` INT NOT NULL,
        `cohort_id` INT NULL,
        `reference` VARCHAR(100) NOT NULL,
        `paystack_reference` VARCHAR(100) NULL,
        `amount` INT UNSIGNED NOT NULL COMMENT 'Amount in kobo',
        `currency` VARCHAR(10) NOT NULL DEFAULT 'NGN',
        `channel` VARCHAR(50) NULL,
        `status` ENUM('pending', 'success', 'failed', 'abandoned') NOT NULL DEFAULT 'pending',
        `gateway_response` VARCHAR(255) NULL,
        `customer_email` VARCHAR(255) NOT NULL,
        `metadata` TEXT NULL,
        `paid_at` DATETIME NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `uniq_tx_reference` (`reference`),
        INDEX `idx_tx_application_id` (`application_id`),
        INDEX `idx_tx_program_cohort` (`program_id`, `cohort_id`),
        INDEX `idx_tx_status` (`status`),
        INDEX `idx_tx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $db->exec($sql);
    $db->exec("ALTER TABLE `payment_transactions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "[OK] Table `payment_transactions` ensured with utf8mb4_general_ci.\n";

    // 5. Backfill existing applications safely
    $db->exec("UPDATE `training_registrations` SET `payment_status` = 'not_required' WHERE `payment_status` IS NULL OR `payment_status` = ''");
    echo "[OK] Backfilled legacy application records with 'not_required'.\n";

    echo "Migration completed successfully!\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
