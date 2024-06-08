-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 08 avr. 2024 à 22:42
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bazaar_books`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign key to `book` table referencing `author` table
ALTER TABLE `book` ADD CONSTRAINT `author_fk` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

-- Add foreign key to `book` table referencing `category` table
ALTER TABLE `book` ADD CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

-- --------------------------------------------------------
--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bookcart`
--

DROP TABLE IF EXISTS `bookcart`;
CREATE TABLE IF NOT EXISTS `bookcart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `user_id` int NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  -- Add foreign key to `bookcart` table referencing `book` table
  Alter table `bookcart` add foreign key (`book_id`) references `book` (`id`);
  -- Add foreign key to `bookcart` table referencing `user` table
  Alter table `bookcart` add foreign key (`user_id`) references `user` (`id`);


-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dateOrder` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `zip_code` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign key to `orders` table referencing `user` table
ALTER TABLE `orders` ADD CONSTRAINT `order_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);


-- --------------------------------------------------------



--
-- Structure de la table `bookorder`
--



DROP TABLE IF EXISTS `bookorder`;
CREATE TABLE IF NOT EXISTS `bookorder` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `order_id` int NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Add foreign key to `bookorder` table referencing `book` table

ALTER TABLE `bookorder` ADD CONSTRAINT `bookorder_book_fk` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

-- Add foreign key to `bookorder` table referencing `orders` table

ALTER TABLE `bookorder` ADD CONSTRAINT `bookorder_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Add foreign key to `wishlist` table referencing `book` table
ALTER TABLE `wishlist` ADD CONSTRAINT `wishlist_book_fk` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

-- Add foreign key to `wishlist` table referencing `user` table

ALTER TABLE `wishlist` ADD CONSTRAINT `wishlist_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `user` ADD `is_banned` BOOLEAN NOT NULL DEFAULT FALSE AFTER `role`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
