# создаем базу
CREATE DATABASE `blog`
  COLLATE utf8_general_ci;

USE `blog`;

# таблица пользователей
CREATE TABLE `users` (
  `id`    INT AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(255) NOT NULL UNIQUE
);

# таблица сообщений
CREATE TABLE `messages` (
  `id`      INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `message` TEXT,
  `time`    DATETIME
);