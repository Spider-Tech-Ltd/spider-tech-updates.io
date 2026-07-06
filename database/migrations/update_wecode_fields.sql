-- Migration to update WE CODE training program form fields
-- This aligns the WE CODE program with the comprehensive data collection of Jobberman programs.

-- 1. Ensure Background Information fields exist for programs named like '%WE CODE%'
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'state_of_origin', 'State of Origin', 'select', 1, 4, 'Background Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%'
ON DUPLICATE KEY UPDATE `field_label` = VALUES(`field_label`), `field_section` = VALUES(`field_section`);

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'local_government', 'Local Government Area', 'select', 1, 5, 'Background Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%'
ON DUPLICATE KEY UPDATE `field_label` = VALUES(`field_label`), `field_section` = VALUES(`field_section`);

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'highest_qualification', 'Highest Qualification', 'select', 1, 6, 'Background Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%'
ON DUPLICATE KEY UPDATE `field_label` = VALUES(`field_label`), `field_section` = VALUES(`field_section`);

-- 2. Ensure Professional Details fields
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'employment_status', 'Employment Status', 'select', 1, 7, 'Professional Details', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%'
ON DUPLICATE KEY UPDATE `field_label` = VALUES(`field_label`), `field_section` = VALUES(`field_section`);

-- 3. Ensure Basic Information fields (e.g., Gender)
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'gender', 'Gender', 'radio', 1, 8, 'Basic Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%'
ON DUPLICATE KEY UPDATE `field_label` = VALUES(`field_label`), `field_section` = VALUES(`field_section`);

-- 4. Update Options for the newly added/updated fields
UPDATE `training_form_fields` SET `options` = '["Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "FCT", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara"]'
WHERE `field_name` = 'state_of_origin' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["FSLC", "SSCE", "OND", "HND", "BSc", "MSc", "PhD"]'
WHERE `field_name` = 'highest_qualification' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Employed", "Unemployed", "Self-Employed", "Student"]'
WHERE `field_name` = 'employment_status' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Male", "Female"]'
WHERE `field_name` = 'gender' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');
