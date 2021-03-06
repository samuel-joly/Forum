-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 27 fév. 2020 à 13:57
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Structure de la table `discussions`
--

DROP TABLE IF EXISTS `discussions`;
CREATE TABLE IF NOT EXISTS `discussions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `id_topic` int(11) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `discussions`
--

INSERT INTO `discussions` (`id`, `titre`, `id_topic`, `id_createur`, `date_time`) VALUES
(1, 'Comment se faire Ban IP ?', 1, 1, '2020-01-25 11:51:18'),
(2, 'Pourquoi des rÃ¨gles ?', 1, 2, '2020-01-25 11:51:38'),
(3, 'Changer les rÃ¨gles', 1, 3, '2020-01-25 11:51:55'),
(4, 'Dark Soul 1 mage OP', 2, 1, '2020-01-26 03:28:03'),
(5, 'CrÃ©er une regle ', 1, 1, '2020-01-26 03:08:39');

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `droits`
--

DROP TABLE IF EXISTS `droits`;
CREATE TABLE IF NOT EXISTS `droits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `droits`
--

INSERT INTO `droits` (`id`, `nom`) VALUES
(1, 'utilisateur'),
(2, 'modérateur'),
(3, 'administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_createur` int(11) NOT NULL,
  `texte` text NOT NULL,
  `id_discussion` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `id_createur`, `texte`, `id_discussion`, `date_time`) VALUES
(1, 2, 'Quelqu\'un pour lui dire de se taire ?\r\n', 1, '2020-01-26 03:35:17'),
(2, 1, 'Nul ne tait le seigneur', 1, '2020-01-26 02:44:06'),
(3, 1, 'C + 5imp13', 2, '2020-01-26 02:50:02'),
(4, 3, 'On peut changer les regles ? \r\nSi je veux qu\'on puisse pas changer les regles comment on fait ?', 3, '2020-01-09 10:17:33'),
(5, 1, 'Comment ?', 5, '2020-01-26 03:13:05'),
(14, 1, 'Toute sauf la premiere bien sur  ', 3, '2020-01-26 03:29:45'),
(7, 1, 'Pourquoi ?', 5, '2020-01-26 03:14:17'),
(8, 1, 'Aussi - dur', 2, '2020-01-26 03:14:27'),
(13, 1, 'Autrement dit comment le faire sans skills', 4, '2020-01-26 03:27:34'),
(12, 1, 'Comment tuer l\'hydre rapidement ?', 4, '2020-01-26 03:27:08'),
(15, 1, 'Sauf si tu veux te faire Ban IP ce qui n\'arrivera que dans 1 cas, si la loi nous l\'impose, nous n\'avons pas le choix', 1, '2020-01-26 03:44:46'),
(16, 1, 'Apres c\'est toi qui vois, si tu veux vendre des armes ou de la drogues, tu vas pas faire long feu ici', 1, '2020-01-26 03:49:15'),
(17, 1, 'Plus simple pour fÃ©dÃ©rer que de le faire avec des lois pour tous', 2, '2020-01-26 16:52:37'),
(18, 1, ',kjdfnl f;pk s;k\r\n', 1, '2020-01-28 16:26:15'),
(19, 7, 'd.sflnself\r\n', 1, '2020-02-27 14:18:51'),
(20, 7, 'dfsefef', 1, '2020-02-27 14:18:53'),
(21, 7, 'fefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsf', 1, '2020-02-27 14:19:04'),
(22, 7, 'fefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsf fefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsffefsfsf\r\n', 1, '2020-02-27 14:19:12'),
(23, 7, 'dlsfkjseovmslev', 1, '2020-02-27 14:19:17'),
(24, 7, 'd.svmdmvs;emv', 1, '2020-02-27 14:19:20');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `visibilite` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id`, `titre`, `id_createur`, `date_time`, `visibilite`, `image`) VALUES
(1, 'Regles du forum', 1, '2020-01-23 07:20:25', 1, 'topicImages/regles.png'),
(2, 'Jeux videos', 2, '2020-01-14 14:46:24', 2, 'topicImages/video-game.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `profilPic` varchar(250) NOT NULL,
  `id_droits` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `mdp`, `profilPic`, `id_droits`) VALUES
(1, 'admin', '$2y$10$zy2AaSsCE/zI9bStYVNQv./L1wGs5LyNmGAoFa/KaQw2Qkj85bGK6', 'profilPics/admin.png', 1),
(2, 'admine', '$2y$10$zy2AaSsCE/zI9bStYVNQv./L1wGs5LyNmGAoFa/KaQw2Qkj85bGK6', 'profilPics/admine.png', 2),
(3, 'Thomas', 'toto', 'profilPics/Thomas.png', 1),
(7, 'sam', '$2y$12$I3jEIugMukY7au/./Iw4fu6vsHrkRcR3lfW4WGzKkukdiG/KdYWZO', 'profilPics/.7.png', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
