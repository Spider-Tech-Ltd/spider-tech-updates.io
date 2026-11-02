-- ==============================================================================
-- MIGRATION: Add Form Fields for WE DIGITIZE (Program ID = 8)
-- Matches the complete 17-field structure of DSE (Program ID = 1)
-- Safe, idempotent: Deletes any existing fields for Program 8 to prevent duplicates.
-- ==============================================================================

START TRANSACTION;

-- 1. Clear any existing fields for Program 8 to guarantee zero duplicates
DELETE FROM `training_form_fields` WHERE `program_id` = 8;

-- 2. Insert the complete 17 fields matching DSE (Program 1)
INSERT INTO `training_form_fields` 
(`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `options`, `field_order`, `field_section`, `field_width`) 
VALUES
(8, 'first_name', 'First Name', 'text', 1, NULL, 1, 'Basic Information', 'full'),
(8, 'middle_name', 'Middle Name (Optional)', 'text', 0, NULL, 2, 'Basic Information', 'full'),
(8, 'last_name', 'Last Name', 'text', 1, NULL, 3, 'Basic Information', 'full'),
(8, 'email', 'Email Address', 'email', 1, NULL, 4, 'Basic Information', 'full'),
(8, 'phone', 'Phone Number', 'text', 1, NULL, 5, 'Basic Information', 'full'),
(8, 'age', 'Age', 'select', 1, '["18-22","23-27","28-32","33-37","38+"]', 6, 'Background Information', 'half'),
(8, 'gender', 'Gender', 'select', 1, '["Male","Female","Other"]', 7, 'Background Information', 'half'),
(8, 'state_of_origin', 'State of Origin', 'select', 1, '["Abia","Adamawa","Akwa Ibom","Anambra","Bauchi","Bayelsa","Benue","Borno","Cross River","Delta","Ebonyi","Edo","Ekiti","Enugu","FCT","Gombe","Imo","Jigawa","Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos","Nasarawa","Niger","Ogun","Ondo","Osun","Oyo","Plateau","Rivers","Sokoto","Taraba","Yobe","Zamfara"]', 8, 'Background Information', 'half'),
(8, 'local_government', 'Local Government Area', 'select', 1, '[]', 9, 'Background Information', 'half'),
(8, 'business_name', 'Business Name', 'text', 1, NULL, 10, 'Professional Details', 'full'),
(8, 'business_section', 'Business Section', 'select', 1, '["Fashion","Catering","Health","Manufacturing","Retail","Education","Agriculture","Others"]', 11, 'Professional Details', 'half'),
(8, 'business_stage', 'Business Stage', 'select', 1, '["Idea Phase","Startup","Established"]', 12, 'Professional Details', 'half'),
(8, 'years_of_experience', 'Years of Experience', 'select', 1, '["1","2","3","4","5+"]', 13, 'Professional Details', 'full'),
(8, 'business_address', 'Business Address', 'text', 1, NULL, 14, 'Professional Details', 'full'),
(8, 'professional_info', 'Professional Info (Certificate/CAC/SMEDAN)', 'file', 0, NULL, 15, 'Additional Information', 'full'),
(8, 'id_upload', 'ID Proof (PDF/Image)', 'file', 0, NULL, 16, 'Additional Information', 'full'),
(8, 'comments', 'Additional Comments', 'textarea', 0, NULL, 17, 'Additional Information', 'full');

COMMIT;
