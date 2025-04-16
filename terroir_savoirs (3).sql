-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 15 avr. 2025 à 12:24
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `terroir_savoirs`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('client','admin','brasseurs','caissier','direction') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'client',
  `mdp_reset` tinyint(1) DEFAULT '0',
  `points` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom_utilisateur`, `email`, `mdp`, `role`, `mdp_reset`, `points`) VALUES
(13, 'admin', 'admin@test.com', '$2y$10$OAbzKC11/11utFfXw1WzO.TApiH8z5swlzO1YkLxOydJ4ARvnlriy', 'admin', 0, 0),
(12, 'user', 'user@test.com', '$2y$10$2rjFLVQg4XMNSNUzlYcbd.SUZ0YnnxA8KmmrjMqMnbugfI6MOhDAm', 'client', 0, 9),
(15, 'bra', 'bra@test.com', '$2y$10$xUehE4OQKGXDbgnbs1uQIeJ4cBgop2kYY4MGBA91Fkp0reV6b6m42', 'brasseurs', 0, 0),
(16, 'cai', 'cai@test.com', '$2y$10$D7vJxQnOcXTtpoD/.K/BKuAp3Vl7i1CAuhReW4hRm1fpiAzc7jZjS', 'caissier', 0, 0),
(17, 'dir', 'dir@test.com', '$2y$10$DNTpBL91M3A245TxGWVB5.u/JeuVGeNlVMzA5G4c5gDHn76l0YWpq', 'direction', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `finances`
--

DROP TABLE IF EXISTS `finances`;
CREATE TABLE IF NOT EXISTS `finances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` enum('expense','revenue') NOT NULL,
  `description` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_prem`
--

DROP TABLE IF EXISTS `matiere_prem`;
CREATE TABLE IF NOT EXISTS `matiere_prem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `quantite` int NOT NULL,
  `unite` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `matiere_prem`
--

INSERT INTO `matiere_prem` (`id`, `nom`, `quantite`, `unite`) VALUES
(1, 'Malt', 100, 'kg'),
(2, 'Houblon', 50, 'g'),
(3, 'Levure', 20, 'g'),
(4, 'Eau', 1000, 'L');

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brasseur_id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `volume` float NOT NULL,
  `alcool` float NOT NULL,
  `ebc` float NOT NULL,
  `malt` float NOT NULL,
  `brassage` float NOT NULL,
  `eaurince` float NOT NULL,
  `mcu` float NOT NULL,
  `ebcresultat` float NOT NULL,
  `srm` float NOT NULL,
  `levure` float NOT NULL,
  `houblon` float NOT NULL,
  `arome` float NOT NULL,
  `creer_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `brasseur_id` (`brasseur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id`, `brasseur_id`, `nom`, `volume`, `alcool`, `ebc`, `malt`, `brassage`, `eaurince`, `mcu`, `ebcresultat`, `srm`, `levure`, `houblon`, `arome`, `creer_le`) VALUES
(1, 15, 'Blonde', 1, 5, 6, 0.25, 0.7, 0.76, 6.345, 10.4394, 5.30322, 0.5, 3, 1, '2025-04-11 12:27:36'),
(2, 15, 'Blonde Forte', 2, 9, 5, 0.9, 2.52, 0.736, 9.5175, 13.7866, 7.00359, 1, 6, 2, '2025-04-11 13:15:24');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `biere` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantite` int NOT NULL,
  `nom_reservation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_reservation` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'en-cours',
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`utilisateur_id`),
  KEY `fk_beer` (`biere`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `utilisateur_id`, `biere`, `quantite`, `nom_reservation`, `date_reservation`, `status`, `prix`) VALUES
(11, 12, 'brune', 5, 'Test', '2025-03-25', 'finalise', 0.00),
(10, 12, 'rouge', 1, 'A', '2025-03-25', 'finalise', 0.00),
(9, 12, 'blonde', 1, 'A', '2025-03-25', 'finalise', 0.00),
(12, 12, 'rouge', 5, 'Test', '2025-03-25', 'finalise', 0.00),
(13, 12, 'blonde', 1, 'Test', '2025-03-25', 'finalise', 0.00),
(14, 12, 'blonde', 8, 'user', '2025-04-11', 'en-cours', 0.00),
(15, 12, 'brune', 4, 'userrr', '2025-04-11', 'en-cours', 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `biere` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `biere`, `quantite`, `prix`) VALUES
(1, 'blonde', 40, 4.00),
(2, 'brune', 30, 5.00),
(3, 'rouge', 32, 6.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
