-- 1. Create Training Form Fields Table
CREATE TABLE IF NOT EXISTS `training_form_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL,
  `field_name` varchar(50) NOT NULL,
  `field_label` varchar(100) NOT NULL,
  `field_type` enum('text', 'email', 'number', 'select', 'file', 'textarea', 'radio', 'checkbox') NOT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `options` json DEFAULT NULL, -- For select, radio, checkbox
  `field_order` int DEFAULT 0,
  `field_section` enum('Basic Information', 'Background Information', 'Professional Details', 'Additional Information') DEFAULT 'Basic Information',
  `field_width` enum('full', 'half') DEFAULT 'full',
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  FOREIGN KEY (`program_id`) REFERENCES `trainings_tb`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Create Dynamic Registrations Table
CREATE TABLE IF NOT EXISTS `training_registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL,
  `user_data` json NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  FOREIGN KEY (`program_id`) REFERENCES `trainings_tb`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Seed Example Data
-- Program 1: Digital Skills for Entrepreneurs
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`) VALUES
(1, 'full_name', 'Full Name', 'text', 1, 1, 'Basic Information', 'half'),
(1, 'email', 'Email Address', 'email', 1, 2, 'Basic Information', 'half'),
(1, 'phone', 'Phone Number', 'text', 1, 3, 'Basic Information', 'full'),
(1, 'state_of_origin', 'State of Origin', 'select', 1, 4, 'Background Information', 'half'),
(1, 'local_government', 'Local Government Area', 'select', 1, 5, 'Background Information', 'half'),
(1, 'business_stage', 'Business Stage', 'select', 1, 6, 'Background Information', 'full'),
(1, 'id_upload', 'ID Proof (PDF/Image)', 'file', 0, 7, 'Professional Details', 'full'),
(1, 'comments', 'Additional Comments', 'textarea', 0, 8, 'Additional Information', 'full');

UPDATE `training_form_fields` SET `options` = '["Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "FCT", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara"]' WHERE `field_name` = 'state_of_origin' AND `program_id` = 1;
UPDATE `training_form_fields` SET `options` = '["Idea Phase", "Startup", "Established"]' WHERE `field_name` = 'business_stage' AND `program_id` = 1;
UPDATE `training_form_fields` SET `options` = '[]' WHERE `field_name` = 'local_government' AND `program_id` = 1;

-- Program 2: Advanced Web Development
INSERT INTO `trainings_tb` (`id`, `training_name`, `training_description`, `training_details`, `training_icon`, `training_image`) VALUES
(2, 'ADVANCED WEB DEVELOPMENT', 'Master modern web technologies including PHP, MySQL and Bootstrap.', 'Detailed course content for Advanced Web Development...', 'flat flaticon-computer-graphic', '../images/pictures/web_dev.png')
ON DUPLICATE KEY UPDATE `training_name`=`training_name`;

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`) VALUES
(2, 'name', 'Name', 'text', 1, 1, 'Basic Information', 'half'),
(2, 'email', 'Email', 'email', 1, 2, 'Basic Information', 'half'),
(2, 'github_url', 'GitHub Profile URL', 'text', 0, 3, 'Professional Details', 'full'),
(2, 'experience_years', 'Years of Experience', 'number', 1, 4, 'Background Information', 'half'),
(2, 'preferred_stack', 'Preferred Tech Stack', 'radio', 1, 5, 'Professional Details', 'half');

UPDATE `training_form_fields` SET `options` = '["Frontend", "Backend", "Fullstack"]' WHERE `field_name` = 'preferred_stack' AND `program_id` = 2;
