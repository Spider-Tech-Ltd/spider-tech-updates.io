-- Drop existing tables if they exist to start fresh
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS category_members;
DROP TABLE IF EXISTS feeds;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Members Table
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Categories Table
CREATE TABLE categories (
    uuid CHAR(36) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Feeds Table
CREATE TABLE feeds (
    uuid CHAR(36) PRIMARY KEY,
    category_uuid CHAR(36) NOT NULL,
    member_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('published', 'draft', 'archived') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_uuid) REFERENCES categories(uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Category Members Pivot Table
CREATE TABLE category_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    category_uuid CHAR(36) NOT NULL,
    role ENUM('member', 'admin') DEFAULT 'member',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (category_uuid) REFERENCES categories(uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY (member_id, category_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Categories
INSERT INTO categories (uuid, name, slug, description, created_at, updated_at) VALUES
('c1a1b2c3-d4e5-6789-0123-abcdef00001', 'Entrepreneurship', 'entrepreneurship', 'Content about startups, business ideas, small businesses, and entrepreneurship tips.', NOW(), NOW()),
('c1a1b2c3-d4e5-6789-0123-abcdef00002', 'Logistics', 'logistics', 'News and tips about supply chain, shipping, transport, and delivery management.', NOW(), NOW()),
('c1a1b2c3-d4e5-6789-0123-abcdef00003', 'Tech', 'tech', 'Updates on software, hardware, AI, programming, and general technology trends.', NOW(), NOW()),
('c1a1b2c3-d4e5-6789-0123-abcdef00004', 'Finance', 'finance', 'Investment, personal finance, business funding, and financial literacy content.', NOW(), NOW()),
('c1a1b2c3-d4e5-6789-0123-abcdef00005', 'Lifestyle', 'lifestyle', 'Personal development, health, wellness, work-life balance, and community content.', NOW(), NOW());

-- Sample Members (passwords are 'password123')
INSERT INTO members (uuid, name, email, password_hash) VALUES
('u1a1b2c3-d4e5-6789-0123-abcdef00001', 'Alan Turing', 'alan@spider.tech', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('u1a1b2c3-d4e5-6789-0123-abcdef00002', 'Ada Lovelace', 'ada@spider.tech', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Sample Category Memberships
INSERT INTO category_members (member_id, category_uuid, role) VALUES
(1, 'c1a1b2c3-d4e5-6789-0123-abcdef00003', 'admin'),
(2, 'c1a1b2c3-d4e5-6789-0123-abcdef00003', 'member'),
(2, 'c1a1b2c3-d4e5-6789-0123-abcdef00001', 'member');

-- Sample Feeds
INSERT INTO feeds (uuid, category_uuid, member_id, title, content, status) VALUES
('f1a1b2c3-d4e5-6789-0123-abcdef00001', 'c1a1b2c3-d4e5-6789-0123-abcdef00003', 1, 'The Future of AI in Manufacturing', 'AI is transforming the industrial landscape by improving efficiency...', 'published'),
('f1a1b2c3-d4e5-6789-0123-abcdef00002', 'c1a1b2c3-d4e5-6789-0123-abcdef00001', 2, 'Starting Your Tech Venture', 'Key things to consider when building a tech startup from scratch...', 'published');
