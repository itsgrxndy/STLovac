-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 02 mars 2021 à 20:35
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP : 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `id16129291_stlovac`
--

-- --------------------------------------------------------

--
-- Structure de la table `actu`
--

CREATE TABLE `actu` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` mediumtext COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `actu`
--

INSERT INTO `actu` (`id`, `nom`, `description`) VALUES
(1, 'pull st marc', 'les pulls de st marc arrive bientot au lycee. \nnormalement apres les vacances sil il ny a pas de problemes avec le corona.\nmerci de votre patiente et de votre confiance '),
(2, 'Bac Blanc', 'Le bac blanc du lycee st marc :\nLe bac blanc des terminales se derouleront le lundi de 8h10 a\n 10h00 et le vendredi de 10h00 a 12h50.\nLe bac blanc des premieres se deroulera de 8h10 a 11h50 le mercredi. ');

-- --------------------------------------------------------

--
-- Structure de la table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 2, 1, '😁wsh gros\n', '2021-02-23 17:15:47', 0),
(2, 2, 1, '🙃', '2021-02-23 17:16:02', 0),
(3, 2, 1, '🤩', '2021-02-23 17:16:07', 0),
(4, 2, 1, '😁😀', '2021-02-23 17:16:17', 0),
(5, 2, 1, 'fghjfhjfghjghj\n\n', '2021-02-23 17:17:56', 0),
(6, 2, 1, 'hjkgu\nuglu\njly\n', '2021-02-23 17:18:06', 0),
(7, 1, 35, 'cc', '2021-02-23 18:53:30', 0),
(8, 35, 1, 'Cc', '2021-02-23 18:54:38', 0),
(9, 1, 35, 'wsh', '2021-02-23 19:51:45', 0),
(10, 1, 35, '😀🤩😍', '2021-02-23 20:01:03', 0),
(11, 35, 1, 'test 😂', '2021-02-23 20:02:35', 0),
(12, 1, 36, '😂😂😂', '2021-02-24 12:54:41', 0),
(13, 36, 1, 'wsh', '2021-02-24 12:55:05', 0),
(14, 25, 1, 'cc leo', '2021-02-25 07:17:21', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `commentaire` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `anonyme` mediumtext COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `id_membre`, `pseudo`, `commentaire`, `anonyme`) VALUES
(12, 31, 'Ginet Tristan ', 'Je recherche un fameux baptiste la grue qui me fait tordre comme la tour de pize ', '0');

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL COMMENT 'id_membre',
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Déchargement des données de la table `dislikes`
--

INSERT INTO `dislikes` (`id`, `id_destinataire`, `id_membre`) VALUES
(19, 31, 1);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id`, `id_destinataire`, `id_membre`) VALUES
(27, 29, 30),
(28, 1, 30),
(29, 32, 1),
(31, 24, 1),
(32, 33, 1),
(34, 26, 1);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_destinataire`, `id_membre`) VALUES
(36, 29, 30),
(37, 1, 30),
(39, 33, 1),
(41, 24, 1),
(42, 26, 1);

-- --------------------------------------------------------

--
-- Structure de la table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_email`, `last_activity`, `is_type`) VALUES
(1, 'kylian.grandy@gmail.com', '2021-03-02 20:35:54', 'no'),
(2, 'roxy.zambelli@icloud.com', '2021-02-23 17:36:41', 'no'),
(3, 'badolleo@gmail.com', '2021-02-25 07:17:54', 'no'),
(4, 'seanmorlac@gmail.com', '2021-02-24 14:03:20', 'no'),
(5, 'romaintranne0710@gmail.com', '2021-02-24 14:03:20', 'no'),
(6, 'baptiste13.lagrut@gmail.com', '2021-02-24 14:03:20', 'no'),
(7, 'trgelectro@gmail.com', '2021-02-24 14:03:20', 'no'),
(8, 'ewanprefot@gmail.com', '2021-02-24 14:03:20', 'no'),
(9, 'quentin.romet38@gmail.com', '2021-02-24 14:03:20', 'no');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `gern` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `nomprenom` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `classe` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `snap` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `insta` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `prenom`, `email`, `mdp`, `gern`, `description`, `nomprenom`, `classe`, `snap`, `insta`) VALUES
(1, 'Grandy', 'Kylian', 'kylian.grandy@gmail.com', '$2y$10$PlWugF7HtYNNCDUbB9g9juOYMQlkBxybTepA2AM31Lh1atp7GavzS', 'Homme', 'jai 17 ans je suis célibataire et je suis en terminal générale 8 ❤️', 'Grandy Kylian', 'Terminale', 'snakboy38', 'kyky_3_8'),
(24, 'zambelli', 'roxane', 'roxy.zambelli@icloud.com', '$2y$10$vPCO.2V.4kreErQKaX4ChuA.ByqEowcWFb35Xq5d.o1cOsX7GEoBu', 'Femme', '.', 'zambelli roxane', 'Terminale', 'roxy-swag', 'roxanezmb'),
(25, 'BADOL', 'Leo', 'badolleo@gmail.com', '$2y$10$6DDx65wzLEvvc/hrD/Jzo.5G3kALRTgQ2WN9ajE9BMcdfvvK9fUQ.', 'Homme', 'On est pas la pour etre la', 'BADOL Leo', 'Terminale', 'Leo.b38', 'Badolleo'),
(26, 'Morlac', 'Sean', 'seanmorlac@gmail.com', '$2y$10$0qIY750gLfbDsjV3Y.4zCO4SR5L8wYpC3iRIrUzHM4NTGG7RNt.PG', 'Homme', 'Le mec est bon', 'Morlac Sean', 'Terminale', 'The_cheune', 'Sean_mrlc'),
(27, 'Tran', 'Romain', 'romaintranne0710@gmail.com', '$2y$10$IWIyP2YVYbb7gedU9g7Ll.rmKLcBP2BVp4ewQbMImRkGHWa7RY5Q6', 'Homme', 'bonjour', 'Tran Romain', 'Terminale', 'rom1.tran', ''),
(30, 'Lagrut', 'Baptiste', 'baptiste13.lagrut@gmail.com', '$2y$10$Pw43buaHuFVbCpasDH7wYuEFPTdXVQze07bLqxHddZwqogSAIwg5K', 'Homme', 'Trop BG', 'Lagrut Baptiste', 'Terminale', 'baptiste_lag', 'baptiste_lagrut'),
(31, 'Ginet', 'Tristan ', 'trgelectro@gmail.com', '$2y$10$mHv0djHFSS.JDIbkKvgg/e3GQv5S9VwFuXYNzyy2Vv50DsXly8iPi', 'Homme', 'Je suis le meilleur ', 'Ginet Tristan ', 'Terminale', 'Gnt', 'gnt.tristan'),
(32, 'Prefot', 'Ewan', 'ewanprefot@gmail.com', '$2y$10$Z1oZPZhY.iJSnFrm2ZANR.1Ei/Fkg3X/cw5syrfzYlndcRHgYKW0C', 'Homme', 'Je vis', 'Prefot Ewan', 'Terminale', 'ewanprefot', 'ewan_prefot'),
(33, 'Romet ', 'Quentin', 'quentin.romet38@gmail.com', '$2y$10$FL82HGFsqgMTbl1evYOcaecJvnJ4Q/XjkkhsL5C/5b.JjopnT2Ski', 'Homme', 'Programmé pour dilater', 'Romet  Quentin', 'Terminale', 'quentin_0903', 'qtnrmt');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id` int(11) NOT NULL,
  `id_comm` int(11) NOT NULL,
  `id_expediteur` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `reponse` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id`, `id_comm`, `id_expediteur`, `id_membre`, `reponse`) VALUES
(23, 12, 31, 1, 'Mdrr 😂');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actu`
--
ALTER TABLE `actu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actu`
--
ALTER TABLE `actu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
