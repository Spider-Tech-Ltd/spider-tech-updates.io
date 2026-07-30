-- 1. Alter the field_section ENUM to include the new categories
ALTER TABLE `training_form_fields`
MODIFY COLUMN `field_section` enum(
    'Basic Information', 
    'Background Information', 
    'Professional Details', 
    'Additional Information',
    'Student Information',
    'Parent/Guardian Information',
    'Bootcamp Information'
) DEFAULT 'Basic Information';

-- 2. Clear existing fields for WE CODE programs
DELETE FROM `training_form_fields`
WHERE `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

-- 3. Insert new fields

-- Student Information
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'student_full_name', 'Student''s Full Name', 'text', 1, 1, 'Student Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'date_of_birth', 'Date of Birth / Age', 'text', 1, 2, 'Student Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'gender', 'Gender', 'radio', 1, 3, 'Student Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'school_name', 'School Name', 'text', 1, 4, 'Student Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'current_class', 'Current Class/Grade', 'text', 1, 5, 'Student Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

-- Parent/Guardian Information
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'parent_name', 'Parent/Guardian Full Name', 'text', 1, 6, 'Parent/Guardian Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'parent_relationship', 'Relationship to Student', 'text', 1, 7, 'Parent/Guardian Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'parent_phone', 'Phone Number', 'text', 1, 8, 'Parent/Guardian Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'parent_email', 'Email Address (Optional)', 'email', 0, 9, 'Parent/Guardian Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'parent_address', 'Home Address', 'textarea', 1, 10, 'Parent/Guardian Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

-- Bootcamp Information
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'has_laptop', 'Does the student have a laptop?', 'radio', 1, 11, 'Bootcamp Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'prior_experience', 'Does the student have any prior coding experience?', 'radio', 1, 12, 'Bootcamp Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'emergency_contact_name', 'Emergency Contact Name', 'text', 1, 13, 'Bootcamp Information', 'full'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`)
SELECT id, 'emergency_contact_phone', 'Emergency Contact Phone Number', 'text', 1, 14, 'Bootcamp Information', 'half'
FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%';


-- Update options for radio fields
UPDATE `training_form_fields` SET `options` = '["Male", "Female", "Other"]'
WHERE `field_name` = 'gender' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Yes", "No"]'
WHERE `field_name` = 'has_laptop' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');

UPDATE `training_form_fields` SET `options` = '["Yes", "No"]'
WHERE `field_name` = 'prior_experience' AND `program_id` IN (SELECT id FROM `trainings_tb` WHERE `training_name` LIKE '%WE CODE%');
