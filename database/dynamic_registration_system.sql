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
  `field_section` enum('Personal Info', 'Demographics', 'Professional Info', 'Additional Info') DEFAULT 'Personal Info',
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
(1, 'full_name', 'Full Name', 'text', 1, 1, 'Personal Info', 'half'),
(1, 'email', 'Email Address', 'email', 1, 2, 'Personal Info', 'half'),
(1, 'phone', 'Phone Number', 'text', 1, 3, 'Personal Info', 'full'),
(1, 'business_stage', 'Business Stage', 'select', 1, 4, 'Demographics', 'full'),
(1, 'id_upload', 'ID Proof (PDF/Image)', 'file', 0, 5, 'Professional Info', 'full'),
(1, 'comments', 'Additional Comments', 'textarea', 0, 6, 'Additional Info', 'full');

UPDATE `training_form_fields` SET `options` = '["Idea Phase", "Startup", "Established"]' WHERE `field_name` = 'business_stage' AND `program_id` = 1;

-- Program 2: Advanced Web Development
INSERT INTO `trainings_tb` (`id`, `training_name`, `training_description`, `training_details`, `training_icon`, `training_image`) VALUES
(2, 'ADVANCED WEB DEVELOPMENT', 'Master modern web technologies including PHP, MySQL and Bootstrap.', 'Detailed course content for Advanced Web Development...', 'flat flaticon-computer-graphic', '../images/pictures/web_dev.png')
ON DUPLICATE KEY UPDATE `training_name`=`training_name`;

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`, `field_section`, `field_width`) VALUES
(2, 'name', 'Name', 'text', 1, 1, 'Personal Info', 'half'),
(2, 'email', 'Email', 'email', 1, 2, 'Personal Info', 'half'),
(2, 'github_url', 'GitHub Profile URL', 'text', 0, 3, 'Professional Info', 'full'),
(2, 'experience_years', 'Years of Experience', 'number', 1, 4, 'Demographics', 'half'),
(2, 'preferred_stack', 'Preferred Tech Stack', 'radio', 1, 5, 'Professional Info', 'half');

UPDATE `training_form_fields` SET `options` = '["Frontend", "Backend", "Fullstack"]' WHERE `field_name` = 'preferred_stack' AND `program_id` = 2;
