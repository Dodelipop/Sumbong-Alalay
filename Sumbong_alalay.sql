CREATE DATABASE IF NOT EXISTS `sumbong_alalay` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sumbong_alalay`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reports` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reporter_name` VARCHAR(255) NOT NULL,
  `age` INT NOT NULL,
  `location` TEXT NOT NULL,
  `concern_type` VARCHAR(100) NOT NULL,
  `status` ENUM('Pending', 'Resolved') DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `password`) VALUES ('admin', 'admin1234')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);