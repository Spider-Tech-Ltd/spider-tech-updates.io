-- ==============================================================================
-- PRODUCTION MIGRATION SCRIPT FOR CPANEL PHPMYADMIN
-- Description: Sets up partners_tb, training_cohorts, cohort_id foreign links,
--              cohort topbar announcements, and backfills initial production data.
-- Safe, idempotent, can be safely re-run multiple times without data loss.
-- ==============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- ------------------------------------------------------------------------------
-- 1. CREATE PARTNERS TABLE (partners_tb)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `partners_tb` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `logo` VARCHAR(255) NOT NULL,
  `website_url` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 2. CREATE TRAINING COHORTS TABLE (training_cohorts)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `training_cohorts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `training_id` INT(11) NOT NULL,
  `cohort_number` INT(11) NOT NULL,
  `cohort_name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `registration_open` TINYINT(1) NOT NULL DEFAULT 0,
  `show_topbar_banner` TINYINT(1) NOT NULL DEFAULT 1,
  `custom_announcement` VARCHAR(255) DEFAULT NULL,
  `registration_deadline` DATETIME DEFAULT NULL,
  `capacity` INT(11) DEFAULT 0,
  `status` ENUM('upcoming','open','ongoing','completed') NOT NULL DEFAULT 'upcoming',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_training_cohort_slug` (`slug`),
  KEY `idx_training_cohort` (`training_id`,`cohort_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------------------------------
-- 3. ENSURE COLUMNS EXIST IN training_cohorts (IF TABLE ALREADY EXISTED)
-- ------------------------------------------------------------------------------
SET @dbname = DATABASE();

-- Ensure `show_topbar_banner`
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = 'training_cohorts' AND COLUMN_NAME = 'show_topbar_banner');
SET @stmt_sql = IF(@col_exists = 0, 'ALTER TABLE `training_cohorts` ADD COLUMN `show_topbar_banner` TINYINT(1) NOT NULL DEFAULT 1 AFTER `registration_open`', 'SELECT 1');
PREPARE stmt FROM @stmt_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ensure `custom_announcement`
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = 'training_cohorts' AND COLUMN_NAME = 'custom_announcement');
SET @stmt_sql = IF(@col_exists = 0, 'ALTER TABLE `training_cohorts` ADD COLUMN `custom_announcement` VARCHAR(255) DEFAULT NULL AFTER `show_topbar_banner`', 'SELECT 1');
PREPARE stmt FROM @stmt_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------------------------
-- 4. ADD cohort_id TO training_registrations (SAFE ADDITIVE CHECK)
-- ------------------------------------------------------------------------------
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = 'training_registrations' AND COLUMN_NAME = 'cohort_id');
SET @stmt_sql = IF(@col_exists = 0, 'ALTER TABLE `training_registrations` ADD COLUMN `cohort_id` INT(11) NULL AFTER `program_id`, ADD INDEX `idx_tr_cohort` (`cohort_id`)', 'SELECT 1');
PREPARE stmt FROM @stmt_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------------------------
-- 5. ADD cohort_id TO events (SAFE ADDITIVE CHECK)
-- ------------------------------------------------------------------------------
SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = 'events' AND COLUMN_NAME = 'cohort_id');
SET @stmt_sql = IF(@col_exists = 0, 'ALTER TABLE `events` ADD COLUMN `cohort_id` INT(11) NULL AFTER `event_id`, ADD INDEX `idx_events_cohort` (`cohort_id`)', 'SELECT 1');
PREPARE stmt FROM @stmt_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------------------------
-- 6. SEED & BACKFILL PARTNERS DATA (partners_tb)
-- ------------------------------------------------------------------------------
INSERT INTO `partners_tb` (`id`, `name`, `logo`, `website_url`, `sort_order`, `is_active`)
VALUES
  (1, 'NITDA Nigeria', 'images/partners/nitda-partner.svg', 'https://nitda.gov.ng', 1, 0),
  (2, 'Google for Startups', 'images/partners/google-startups.svg', 'https://startup.google.com', 2, 0),
  (3, 'Microsoft Tech Impact', 'images/partners/microsoft-partner.svg', 'https://www.microsoft.com/nonprofits', 3, 0),
  (4, 'Edo Innovates', 'images/partners/edo-innovates.svg', 'https://edoinnovates.ng', 4, 0),
  (5, 'Jobberman Nigeria', 'images/partners/jobberman.svg', 'https://www.jobberman.com', 5, 0),
  (6, 'GitHub Education', 'images/partners/github-partner.svg', 'https://education.github.com', 6, 0),
  (7, 'Jobberman', 'images/partners/1793462138_818.svg', 'https://www.jobberman.com/', 7, 1),
  (8, 'TAFTA – Terra Academy for the Arts', 'images/partners/1793462270_832.jpg', 'https://app.terraacademyforarts.com/', 8, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `logo` = VALUES(`logo`),
  `website_url` = VALUES(`website_url`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

-- ------------------------------------------------------------------------------
-- 7. SEED & BACKFILL COHORTS DATA (training_cohorts)
-- ------------------------------------------------------------------------------
INSERT INTO `training_cohorts` (`id`, `training_id`, `cohort_number`, `cohort_name`, `slug`, `start_date`, `end_date`, `registration_open`, `show_topbar_banner`, `custom_announcement`, `registration_deadline`, `capacity`, `status`)
VALUES
  (1, 1, 1, 'Digital Skills for Entrepreneurs - Cohort 1', 'dse-cohort-1', '2024-07-01', '2024-08-31', 0, 1, NULL, '2024-06-30 23:59:59', 50, 'completed'),
  (2, 1, 2, 'Digital Skills for Entrepreneurs - Cohort 2', 'dse-cohort-2', '2024-09-01', '2024-09-30', 0, 1, NULL, '2024-08-31 23:59:59', 60, 'completed'),
  (3, 1, 3, 'Digital Skills for Entrepreneurs - Cohort 3', 'dse-cohort-3', '2024-10-14', '2024-11-30', 0, 1, NULL, '2024-10-13 23:59:59', 75, 'completed'),
  (4, 1, 4, 'Digital Skills for Entrepreneurs - Cohort 4', 'dse-cohort-4', '2026-11-16', '2026-12-18', 1, 1, NULL, '2026-11-15 23:59:00', 100, 'open')
ON DUPLICATE KEY UPDATE
  `cohort_name` = VALUES(`cohort_name`),
  `start_date` = VALUES(`start_date`),
  `end_date` = VALUES(`end_date`),
  `registration_open` = VALUES(`registration_open`),
  `show_topbar_banner` = VALUES(`show_topbar_banner`),
  `registration_deadline` = VALUES(`registration_deadline`),
  `capacity` = VALUES(`capacity`),
  `status` = VALUES(`status`);

-- ------------------------------------------------------------------------------
-- 8. LINK HISTORICAL REGISTRATIONS & EVENTS
-- ------------------------------------------------------------------------------
-- Assign existing unassigned Program 1 registrations to Cohort 3
UPDATE `training_registrations`
SET `cohort_id` = 3
WHERE `program_id` = 1 AND (`cohort_id` IS NULL OR `cohort_id` = 0);

-- Link historical DSE event records to Cohorts 1-3 (if matching events exist)
UPDATE `events` SET `cohort_id` = 1 WHERE `event_id` = 10 AND (`cohort_id` IS NULL OR `cohort_id` = 0);
UPDATE `events` SET `cohort_id` = 2 WHERE `event_id` = 11 AND (`cohort_id` IS NULL OR `cohort_id` = 0);
UPDATE `events` SET `cohort_id` = 3 WHERE `event_id` = 12 AND (`cohort_id` IS NULL OR `cohort_id` = 0);

COMMIT;

-- Verification query (uncomment to review results in phpMyAdmin)
-- SELECT 'partners_tb count' AS tbl, COUNT(*) AS total FROM `partners_tb`
-- UNION ALL
-- SELECT 'training_cohorts count' AS tbl, COUNT(*) AS total FROM `training_cohorts`;
