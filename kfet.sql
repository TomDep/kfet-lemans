-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 01 sep. 2021 à 11:07
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `baristas`
--

INSERT INTO `baristas` (`id`, `user_id`, `class`, `photo`) VALUES
(1, 1, '4A Info', 'undefined.jpg'),
(4, 4, '4A Info', 'Aksel.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_orders`
--

INSERT INTO `item_orders` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(4, 3, 19, 1),
(3, 3, 47, 2),
(5, 4, 8, 1),
(6, 4, 23, 1),
(7, 4, 32, 2),
(8, 5, 47, 1),
(9, 5, 20, 2),
(10, 6, 47, 1),
(11, 6, 20, 2),
(12, 7, 47, 1),
(13, 7, 20, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `datetime`) VALUES
(4, 1, '2021-08-31 15:14:32'),
(3, 1, '2021-08-31 11:29:13'),
(5, 1, '2021-08-31 15:52:12'),
(6, 1, '2021-08-31 15:52:52'),
(7, 1, '2021-08-31 15:53:06'),
(8, 1, '2021-08-31 15:53:24');

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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `bdlc_price`, `category`, `image`) VALUES
(47, 'CafÃ©', '0.40', '0.40', 0, 'CafÃ©.svg'),
(19, 'Sodas', '0.60', '0.60', 1, 'Sodas.svg'),
(8, 'ThÃ©', '0.50', '0.40', 1, 'ThÃ©.svg'),
(16, 'Grand CafÃ©', '0.50', '0.50', 0, 'Grand CafÃ©.svg'),
(17, 'Cacolac', '0.60', '0.60', 1, 'Cacolac.svg'),
(18, 'Jus de Fruits', '0.50', '0.50', 1, 'Jus de Fruits.svg'),
(20, 'Viennoiserie', '0.80', '0.80', 2, 'Viennoiserie.jpg'),
(21, 'Maxi Viennoiserie', '1.20', '1.20', 2, 'Maxi Viennoiserie.jpg'),
(22, 'Cookies', '1.00', '1.00', 2, 'Cookies.jpg'),
(23, 'Cookies Bio', '1.50', '1.50', 2, 'Cookies Bio.jpg'),
(24, 'PÃ©pito', '1.00', '1.00', 2, 'PÃ©pito.jpg'),
(25, 'SablÃ©s Bio', '1.00', '1.00', 2, 'SablÃ©s Bio.jpg'),
(26, 'Biscuits NappÃ©s Bio', '1.80', '1.80', 2, 'Biscuits NappÃ©s Bio.jpg'),
(27, 'Galette de Riz Choco', '1.80', '1.80', 2, 'Galette de Riz Choco.jpg'),
(28, 'Barres CÃ©rÃ©ales', '0.30', '0.30', 2, 'Barres CÃ©rÃ©ales.jpg'),
(29, 'Nouilles InstantannÃ©es', '1.00', '1.00', 2, 'Nouilles InstantannÃ©es.jpg'),
(30, 'Repas Bio', '2.50', '2.50', 2, 'Repas Bio.jpg'),
(31, 'Chips', '0.30', '0.30', 2, 'Chips.jpg'),
(32, 'Kit-Kat', '0.60', '0.60', 2, 'Kit-Kat.jpg'),
(33, 'Mars', '0.60', '0.60', 2, 'Mars.jpg'),
(34, 'Lion', '0.60', '0.60', 2, 'Lion.jpg'),
(35, 'Twiks', '0.60', '0.60', 2, 'Twiks.jpg'),
(36, 'Kinder Bueno', '0.70', '0.70', 2, 'Kinder Bueno.jpg'),
(37, 'Kinder Country', '0.30', '0.30', 2, 'Kinder Country.jpg'),
(38, 'Kinder Maxi', '0.30', '0.30', 2, 'Kinder Maxi.jpg'),
(39, 'Gaufre', '0.30', '0.30', 2, 'Gaufre.jpg'),
(40, 'Mister Freeze', '0.20', '0.20', 2, 'Mister Freeze.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `student_number`, `password`, `username`, `bdlc_member`, `auth_level`, `credit`, `activated`) VALUES
(1, 182355, '$2y$10$zSPFknyInJ1SRascwuWCjOlfh.Twok.507AJiun357UHH8X970wZ6', 'Tom de Pasquale', 0, 2, '1.50', 1),
(4, 202655, '$2y$10$imf/3ULJP3hYB.zaPHXCre.YZxmGQ/N/WzFBgNs55qU129LHj6AMG', 'Aksel', 1, 2, '15.00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
