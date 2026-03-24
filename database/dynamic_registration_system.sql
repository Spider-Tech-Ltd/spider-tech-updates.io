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
INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`) VALUES
(1, 'full_name', 'Full Name', 'text', 1, 1),
(1, 'email', 'Email Address', 'email', 1, 2),
(1, 'phone', 'Phone Number', 'text', 1, 3),
(1, 'business_stage', 'Business Stage', 'select', 1, 4),
(1, 'id_upload', 'ID Proof (PDF/Image)', 'file', 0, 5),
(1, 'comments', 'Additional Comments', 'textarea', 0, 6);

-- Update options for business_stage
UPDATE `training_form_fields` SET `options` = '["Idea Phase", "Startup", "Established"]' WHERE `field_name` = 'business_stage' AND `program_id` = 1;

-- Program 2: Another program (if it exists)
-- Let's check if there is another program in trainings_tb
-- From previous cat, there was only id 1. I'll insert another one for testing if needed or just use id 2 if it exists.
-- Actually, the dumping only showed id 1.

INSERT INTO `trainings_tb` (`id`, `training_name`, `training_description`, `training_details`, `training_icon`, `training_image`) VALUES
(2, 'ADVANCED WEB DEVELOPMENT', 'Master modern web technologies including PHP, MySQL and Bootstrap.', 'Detailed course content for Advanced Web Development...', 'flat flaticon-computer-graphic', '../images/pictures/web_dev.png')
ON DUPLICATE KEY UPDATE `training_name`=`training_name`;

INSERT INTO `training_form_fields` (`program_id`, `field_name`, `field_label`, `field_type`, `is_required`, `field_order`) VALUES
(2, 'name', 'Name', 'text', 1, 1),
(2, 'email', 'Email', 'email', 1, 2),
(2, 'github_url', 'GitHub Profile URL', 'text', 0, 3),
(2, 'experience_years', 'Years of Experience', 'number', 1, 4),
(2, 'preferred_stack', 'Preferred Tech Stack', 'radio', 1, 5);

UPDATE `training_form_fields` SET `options` = '["Frontend", "Backend", "Fullstack"]' WHERE `field_name` = 'preferred_stack' AND `program_id` = 2;
