-- Database: luxurious_creation
-- SQL Script to create all tables for Luxurious Creation Web Application

-- 1. Contact Messages Table (from contact.php)
CREATE TABLE `contact_messages` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(200) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_created_at` (`created_at`)
);

-- 2. Anonymous Contact Table (from contactAno.php)
CREATE TABLE `contactano_lc` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_phone` (`phone`),
    INDEX `idx_created_at` (`created_at`)
);

-- 3. Feedback Table (from feedback.php)
CREATE TABLE `feedback_lc` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `rating` TEXT(10) NOT NULL,
    `suggestions` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_category` (`category`),
    INDEX `idx_rating` (`rating`),
    INDEX `idx_created_at` (`created_at`)
);

-- 4. User Registration Table (from register.php)
CREATE TABLE `register_lc` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `contact` VARCHAR(20) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_username` (`username`),
    UNIQUE KEY `unique_email` (`email`),
    INDEX `idx_email` (`email`),
    INDEX `idx_username` (`username`)
);

-- 5. Login Table (from login.php and register.php)
CREATE TABLE `login_lc` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `last_login` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_username` (`username`),
    INDEX `idx_username` (`username`),
    INDEX `idx_last_login` (`last_login`)
);

-- Add foreign key relationship between register_lc and login_lc
ALTER TABLE `login_lc` 
ADD CONSTRAINT `fk_login_register` 
FOREIGN KEY (`username`) REFERENCES `register_lc`(`username`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Display success message
SELECT 'Database schema created successfully!' as Status;
