-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 juil. 2021 à 13:05
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kfet`
--

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bdlc_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `category` tinyint(4) NOT NULL COMMENT '[0 = boisson chaude | 1 = boisson froide | 2 = snack]',
  `image` varchar(255) NOT NULL DEFAULT 'undefined.jpg',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `bdlc_price`, `category`, `image`) VALUES
(4, 'CafÃ©', '0.40', '0.00', 0, 'cafÃ©.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` mediumint(9) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL,
  `bdlc_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Boolean',
  `auth_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '[0 = basic user | 1 = barista | 2 = admin]',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `activated` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Boolean',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `student_number`, `password`, `username`, `bdlc_member`, `auth_level`, `credit`, `activated`) VALUES
(1, 182355, '$2y$10$ZGHeyUp68lVUWz2pRow1FOftK6cCc2CDwqV1I10wZmTndV0rqQ6vy', 'Tom de Pasquale', 1, 2, '0.00', 1),
(4, 182366, '$2y$10$imf/3ULJP3hYB.zaPHXCre.YZxmGQ/N/WzFBgNs55qU129LHj6AMG', 'Aksel', 1, 0, '0.00', 1),
(3, 182344, '$2y$10$Zy7UYTTkm51L/omtenUa3ukv8OI4zPlj5GBR9NeJDLt4Er8f/cn3G', 'Test Barista', 0, 1, '0.00', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
