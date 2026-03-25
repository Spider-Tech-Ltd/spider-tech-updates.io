-- Add field_section and field_width columns to support categorization and multi-column layout
ALTER TABLE `training_form_fields`
ADD COLUMN `field_section` enum('Personal Info', 'Demographics', 'Professional Info', 'Additional Info') DEFAULT 'Personal Info',
ADD COLUMN `field_width` enum('full', 'half') DEFAULT 'full';

-- Update seed data with sections and widths
-- Program 1: Digital Skills for Entrepreneurs
UPDATE `training_form_fields` SET `field_section` = 'Personal Info', `field_width` = 'half' WHERE `field_name` = 'full_name' AND `program_id` = 1;
UPDATE `training_form_fields` SET `field_section` = 'Personal Info', `field_width` = 'half' WHERE `field_name` = 'email' AND `program_id` = 1;
UPDATE `training_form_fields` SET `field_section` = 'Personal Info', `field_width` = 'full' WHERE `field_name` = 'phone' AND `program_id` = 1;
UPDATE `training_form_fields` SET `field_section` = 'Demographics', `field_width` = 'full' WHERE `field_name` = 'business_stage' AND `program_id` = 1;
UPDATE `training_form_fields` SET `field_section` = 'Professional Info', `field_width` = 'full' WHERE `field_name` = 'id_upload' AND `program_id` = 1;
UPDATE `training_form_fields` SET `field_section` = 'Additional Info', `field_width` = 'full' WHERE `field_name` = 'comments' AND `program_id` = 1;

-- Program 2: Advanced Web Development
UPDATE `training_form_fields` SET `field_section` = 'Personal Info', `field_width` = 'half' WHERE `field_name` = 'name' AND `program_id` = 2;
UPDATE `training_form_fields` SET `field_section` = 'Personal Info', `field_width` = 'half' WHERE `field_name` = 'email' AND `program_id` = 2;
UPDATE `training_form_fields` SET `field_section` = 'Professional Info', `field_width` = 'full' WHERE `field_name` = 'github_url' AND `program_id` = 2;
UPDATE `training_form_fields` SET `field_section` = 'Demographics', `field_width` = 'half' WHERE `field_name` = 'experience_years' AND `program_id` = 2;
UPDATE `training_form_fields` SET `field_section` = 'Professional Info', `field_width` = 'half' WHERE `field_name` = 'preferred_stack' AND `program_id` = 2;
