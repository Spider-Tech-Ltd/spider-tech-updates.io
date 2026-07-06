-- Migration to update WE CODE training program form fields - Precise Ordering
-- This migration clears existing fields and re-adds them in the requested order:
-- Basic Information -> Demographic Information -> Additional Information.

-- 1. Clear existing form fields for WE CODE programs
DELETE FROM `training_form_fields`
WHERE `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

-- 2. Basic Information Section
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'full_name', 'Full Name', 'text', 1, 1, 'Basic Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'email', 'Email Address', 'email', 1, 2, 'Basic Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'phone', 'Phone Number', 'text', 1, 3, 'Basic Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'gender', 'Gender', 'radio', 1, 4, 'Basic Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

-- 3. Demographic Information Section (mapped to 'Background Information' enum)
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'state_of_origin', 'State of Origin', 'select', 1, 5, 'Background Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'local_government', 'Local Government Area', 'select', 1, 6, 'Background Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'highest_qualification', 'Highest Qualification', 'select', 1, 7, 'Background Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

-- 4. Additional Information Section
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'employment_status', 'Current Employment Status', 'select', 1, 8, 'Additional Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'reason_for_joining', 'Why do you want to join this program?', 'textarea', 0, 9, 'Additional Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

-- 5. Set Options for select/radio fields
UPDATE `training_form_fields` SET `options` = '["Male", "Female"]'
WHERE `field_name` = 'gender' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "FCT", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara"]'
WHERE `field_name` = 'state_of_origin' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["FSLC", "SSCE", "OND", "HND", "BSc", "MSc", "PhD", "Other"]'
WHERE `field_name` = 'highest_qualification' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Employed", "Unemployed", "Self-Employed", "Student"]'
WHERE `field_name` = 'employment_status' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');
