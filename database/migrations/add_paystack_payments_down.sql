-- ============================================================================
-- Rollback Migration: Remove Paystack Payment Support for Trainings
-- Date: 2026-11-02
-- ============================================================================

DROP TABLE IF EXISTS `payment_transactions`;

ALTER TABLE `training_registrations`
    DROP INDEX `uniq_payment_reference`,
    DROP INDEX `uniq_invoice_number`,
    DROP INDEX `idx_payment_status`,
    DROP COLUMN `invoice_sent_at`,
    DROP COLUMN `invoice_number`,
    DROP COLUMN `paid_at`,
    DROP COLUMN `currency`,
    DROP COLUMN `amount_paid`,
    DROP COLUMN `payment_reference`,
    DROP COLUMN `payment_status`;

ALTER TABLE `training_cohorts`
    DROP COLUMN `payment_amount`;

ALTER TABLE `trainings_tb`
    DROP COLUMN `payment_amount`,
    DROP COLUMN `payments_enabled`;
