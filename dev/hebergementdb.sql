-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 17 jan. 2022 à 15:24
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hebergementdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `hebergement`
--

CREATE TABLE `hebergement` (
  `id_hebergement` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `prix` smallint(6) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `gps` varchar(50) DEFAULT NULL,
  `wifi` tinyint(1) DEFAULT NULL,
  `fumeur` tinyint(1) DEFAULT NULL,
  `piscine` tinyint(1) DEFAULT NULL,
  `animaux` tinyint(1) DEFAULT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `couchage` int(11) DEFAULT NULL,
  `sdb` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `photo1` varchar(200) DEFAULT NULL,
  `photo2` varchar(200) DEFAULT NULL,
  `photo3` varchar(200) DEFAULT NULL,
  `photo4` varchar(200) DEFAULT NULL,
  `photo5` varchar(200) DEFAULT NULL,
  `id_periode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `hebergement`
--

INSERT INTO `hebergement` (`id_hebergement`, `nom`, `description`, `prix`, `adresse`, `gps`, `wifi`, `fumeur`, `piscine`, `animaux`, `categorie`, `couchage`, `sdb`, `ville`, `pays`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `id_periode`) VALUES
(1, 'gite', 'un gite parfait', 40, '15 rue du balai', NULL, 1, 0, 0, 0, 'gite', 1, 1, 'chambery', 'france', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(10) UNSIGNED NOT NULL,
  `debut` date DEFAULT NULL,
  `fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`id_periode`, `debut`, `fin`) VALUES
(1, '2022-01-17', '2022-01-22'),
(2, '2022-01-17', '2022-01-22'),
(3, '2022-01-17', '2022-01-22'),
(4, '2022-01-17', '2022-01-22'),
(5, '2022-01-17', '2022-01-22'),
(6, '2022-01-17', '2022-01-22'),
(7, '2022-01-17', '2022-01-22'),
(8, '2022-01-17', '2022-01-22'),
(9, '2022-01-17', '2022-01-22'),
(10, '2022-01-17', '2022-01-22'),
(11, '2022-01-17', '2022-01-22'),
(12, '2022-01-17', '2022-01-22'),
(13, '2022-01-17', '2022-01-22'),
(14, '2022-01-17', '2022-01-22'),
(15, '2022-01-17', '2022-01-22'),
(16, '2022-01-17', '2022-01-22'),
(17, '2022-01-17', '2022-01-22');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `hebergement`
--
ALTER TABLE `hebergement`
  ADD PRIMARY KEY (`id_hebergement`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `hebergement`
--
ALTER TABLE `hebergement`
  MODIFY `id_hebergement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
