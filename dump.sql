-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-mvc
-- Généré le :  mer. 10 juin 2020 à 11:38
-- Version du serveur :  5.7.28
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mvcdocker2`
--

-- --------------------------------------------------------

--
-- Structure de la table `tdd_users`
--

CREATE TABLE `dve_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(16) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tdd_users`
--

INSERT INTO `dve_users` (`id`, `firstname`, `lastname`, `email`, `pwd`, `status`, `date_inserted`, `date_updated`) VALUES
(1, 'tib', 'dar', 'tib@gmail.com', 'tt', 0, '2020-05-18 10:01:26', NULL),
(2, 'cha', 'ban', 'cha@gmail.com', 'tttt', 0, '2020-05-18 10:03:05', NULL),
(3, 'Thibault', 'DARGENT', 'tdargent1@gmail.com', 'Test1234', 0, '2020-05-18 10:21:06', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tdd_users`
--
ALTER TABLE `dve_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tdd_users`
--
ALTER TABLE `dve_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

