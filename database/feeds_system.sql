-- Create members table
CREATE TABLE IF NOT EXISTS `members` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uuid` CHAR(36) NOT NULL UNIQUE,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100),
  `role` VARCHAR(50) DEFAULT 'Member',
  `posts` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uuid` CHAR(36) NOT NULL UNIQUE,
  `name` VARCHAR(50) NOT NULL,
  `category` VARCHAR(50) NOT NULL, -- For internal slug/reference
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create feeds table
CREATE TABLE IF NOT EXISTS `feeds` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uuid` CHAR(36) NOT NULL UNIQUE,
  `member_id` CHAR(36) NOT NULL, -- Storing member UUID
  `category_uuid` CHAR(36) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `status` VARCHAR(20) DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (member_id) REFERENCES members(uuid),
  FOREIGN KEY (category_uuid) REFERENCES categories(uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create feed_likes table
CREATE TABLE IF NOT EXISTS `feed_likes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `feed_uuid` CHAR(36) NOT NULL,
  `member_id` CHAR(36) NOT NULL, -- Storing member UUID
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (feed_uuid) REFERENCES feeds(uuid),
  FOREIGN KEY (member_id) REFERENCES members(uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create feed_replies table
CREATE TABLE IF NOT EXISTS `feed_replies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uuid` CHAR(36) NOT NULL UNIQUE,
  `feed_uuid` CHAR(36) NOT NULL,
  `member_id` CHAR(36) NOT NULL, -- Storing member UUID
  `category_uuid` CHAR(36) NOT NULL,
  `content` TEXT NOT NULL,
  `status` VARCHAR(20) DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (feed_uuid) REFERENCES feeds(uuid),
  FOREIGN KEY (member_uuid) REFERENCES members(uuid),
  FOREIGN KEY (category_uuid) REFERENCES categories(uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed categories
INSERT INTO `categories` (`uuid`, `name`, `category`, `description`) VALUES
(UUID(), 'Manufacturing', 'manufacturing', 'Discussions about modern manufacturing processes.'),
(UUID(), 'Automation', 'automation', 'Everything about industrial automation and PLC systems.'),
(UUID(), 'Energy', 'energy', 'Renewable energy, power systems and utilities.'),
(UUID(), 'AI & Robotics', 'ai', 'Artificial intelligence and robotics in industry.'),
(UUID(), 'Logistics', 'logistics', 'Supply chain management and transportation technologies.'),
(UUID(), 'Infrastructure', 'infrastructure', 'Industrial buildings and large scale projects.');
