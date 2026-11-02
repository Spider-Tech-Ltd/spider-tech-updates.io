-- ============================================================================
-- Migration: Add Paystack Payment Support for Trainings Feature
-- Date: 2026-11-02
-- Description: Adds payment configuration to trainings and cohorts, updates
--              registrations table with payment status, and creates the
--              payment_transactions companion table.
-- ============================================================================

-- 1. Update trainings_tb with payment configuration
ALTER TABLE `trainings_tb`
    ADD COLUMN `payments_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `registration_available`,
    ADD COLUMN `payment_amount` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `payments_enabled`;

-- 2. Update training_cohorts with optional cohort payment override
ALTER TABLE `training_cohorts`
    ADD COLUMN `payment_amount` INT UNSIGNED NULL DEFAULT NULL AFTER `capacity`;

-- 3. Update training_registrations with payment & invoice columns
ALTER TABLE `training_registrations`
    ADD COLUMN `payment_status` ENUM('not_required', 'pending', 'success', 'failed', 'abandoned') NOT NULL DEFAULT 'not_required' AFTER `user_data`,
    ADD COLUMN `payment_reference` VARCHAR(100) NULL AFTER `payment_status`,
    ADD COLUMN `amount_paid` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `payment_reference`,
    ADD COLUMN `currency` VARCHAR(10) NOT NULL DEFAULT 'NGN' AFTER `amount_paid`,
    ADD COLUMN `paid_at` DATETIME NULL AFTER `currency`,
    ADD COLUMN `invoice_number` VARCHAR(50) NULL AFTER `paid_at`,
    ADD COLUMN `invoice_sent_at` DATETIME NULL AFTER `invoice_number`,
    ADD UNIQUE KEY `uniq_payment_reference` (`payment_reference`),
    ADD UNIQUE KEY `uniq_invoice_number` (`invoice_number`),
    ADD INDEX `idx_payment_status` (`payment_status`);

-- 4. Create payment_transactions companion table
CREATE TABLE IF NOT EXISTS `payment_transactions` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4b. Ensure collation matches existing tables (utf8mb4_general_ci)
ALTER TABLE `payment_transactions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- 5. Backfill existing applications as 'not_required' (safe idempotency)
UPDATE `training_registrations` 
SET `payment_status` = 'not_required' 
WHERE `payment_status` IS NULL OR `payment_status` = '';
