-- SQL Migration Script for Social Links
-- 1. Create social_links table
CREATE TABLE IF NOT EXISTS social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL UNIQUE,
    url VARCHAR(255) DEFAULT NULL,
    icon_class VARCHAR(100) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Seed initial data
INSERT INTO social_links (platform, url, icon_class) VALUES
('Facebook', 'https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/', 'fab fa-facebook-f'),
('Twitter', 'https://twitter.com/', 'fab fa-twitter'),
('Youtube', 'https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw', 'fab fa-youtube'),
('Linkedin', 'https://linkedin.com/', 'fab fa-linkedin-in'),
('Instagram', 'https://www.instagram.com/spidertech.hub', 'fab fa-instagram')
ON DUPLICATE KEY UPDATE
    url=VALUES(url),
    icon_class=VALUES(icon_class);

-- 3. Ensure profile_pic exists in admin_tb
SET @dbname = DATABASE();
SET @tablename = 'admin_tb';
SET @columnname = 'profile_pic';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' VARCHAR(255) DEFAULT NULL AFTER privilege')
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
