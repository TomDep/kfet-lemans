-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 sep. 2021 à 09:22
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
-- Structure de la table `baristas`
--

DROP TABLE IF EXISTS `baristas`;
CREATE TABLE IF NOT EXISTS `baristas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `class` char(255) NOT NULL DEFAULT '',
  `photo` char(255) NOT NULL DEFAULT 'undefined.jpg',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `baristas`
--

INSERT INTO `baristas` (`id`, `user_id`, `class`, `photo`) VALUES
(7, 1, '4A Info', 'Tom de Pasquale.svg'),
(11, 12, '4A Info', 'Daham Karunanayake.svg');

-- --------------------------------------------------------

--
-- Structure de la table `item_orders`
--

DROP TABLE IF EXISTS `item_orders`;
CREATE TABLE IF NOT EXISTS `item_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_orders`
--

INSERT INTO `item_orders` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(24, 18, 47, 2),
(23, 17, 47, 2),
(22, 16, 47, 1),
(21, 15, 19, 10),
(20, 14, 17, 2),
(19, 13, 47, 1),
(18, 12, 47, 2),
(17, 11, 20, 1),
(16, 11, 47, 2),
(15, 10, 17, 2),
(14, 9, 12, 1),
(25, 19, 47, 2),
(26, 20, 21, 2);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `datetime`) VALUES
(14, 1, '2021-09-14 09:41:17'),
(13, 1, '2021-09-06 15:14:02'),
(12, 1, '2021-09-06 14:38:37'),
(11, 1, '2021-09-06 13:00:25'),
(10, 1, '2021-09-06 12:56:31'),
(9, 1, '2021-09-06 06:50:33'),
(15, 1, '2021-09-14 12:22:00'),
(16, 1, '2021-09-14 12:23:53'),
(17, 1, '2021-09-15 11:20:15'),
(18, 1, '2021-09-30 08:52:30'),
(19, 1, '2021-09-30 08:53:04'),
(20, 1, '2021-09-30 08:59:40');

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
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `bdlc_price`, `category`, `image`) VALUES
(47, 'CafÃ©', '0.40', '0.40', 0, 'CafÃ©.svg'),
(19, 'Sodas', '0.60', '0.60', 1, 'Sodas.svg'),
(8, 'ThÃ©', '0.50', '0.40', 0, 'ThÃ©.svg'),
(16, 'Grand CafÃ©', '0.50', '0.50', 0, 'Grand CafÃ©.svg'),
(17, 'Cacolac', '0.60', '0.60', 1, 'Cacolac.svg'),
(18, 'Jus de Fruits', '0.50', '0.50', 1, 'Jus de Fruits.svg'),
(20, 'Viennoiserie', '0.80', '0.80', 2, 'Viennoiserie.svg'),
(21, 'Maxi Viennoiserie', '1.20', '1.20', 2, 'Maxi Viennoiserie.svg'),
(22, 'Cookies', '1.00', '1.00', 2, 'Cookies.svg'),
(23, 'Cookies Bio', '1.50', '1.50', 2, 'Cookies Bio.svg'),
(24, 'PÃ©pito', '1.00', '1.00', 2, 'PÃ©pito.svg'),
(25, 'SablÃ©s Bio', '1.00', '1.00', 2, 'SablÃ©s Bio.svg'),
(26, 'Biscuits NappÃ©s Bio', '1.80', '1.80', 2, 'Biscuits NappÃ©s Bio.svg'),
(27, 'Galette de Riz Choco', '1.80', '1.80', 2, 'Galette de Riz Choco.svg'),
(28, 'Barres CÃ©rÃ©ales', '0.30', '0.30', 2, 'Barres CÃ©rÃ©ales.svg'),
(29, 'Nouilles InstantannÃ©es', '1.00', '1.00', 2, 'Nouilles InstantannÃ©es.svg'),
(30, 'Repas Bio', '2.50', '2.50', 2, 'Repas Bio.svg'),
(31, 'Chips', '0.30', '0.30', 2, 'Chips.svg'),
(32, 'Kit-Kat', '0.60', '0.60', 2, 'Kit-Kat.svg'),
(33, 'Mars', '0.60', '0.60', 2, 'Mars.svg'),
(34, 'Lion', '0.60', '0.60', 2, 'Lion.svg'),
(35, 'Twiks', '0.60', '0.60', 2, 'Twiks.svg'),
(36, 'Kinder Bueno', '0.70', '0.70', 2, 'Kinder Bueno.svg'),
(37, 'Kinder Country', '0.30', '0.30', 2, 'Kinder Country.svg'),
(38, 'Kinder Maxi', '0.30', '0.30', 2, 'Kinder Maxi.svg'),
(39, 'Gaufre', '0.30', '0.30', 2, 'Gaufre.svg'),
(40, 'Mister Freeze', '0.20', '0.20', 2, 'Mister Freeze.svg');

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `student_number`, `password`, `username`, `bdlc_member`, `auth_level`, `credit`, `activated`) VALUES
(1, 182355, '$2y$10$zSPFknyInJ1SRascwuWCjOlfh.Twok.507AJiun357UHH8X970wZ6', 'Tom de Pasquale', 0, 2, '190.10', 1),
(12, 181619, 'lRWZVT', 'Daham Karunanayake', 0, 0, '0.00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
