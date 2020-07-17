-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Dim 14 Juin 2020 à 14:28
-- Version du serveur :  10.1.44-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `final`
--

-- --------------------------------------------------------

--
-- Structure de la table `champs`
--

CREATE TABLE `champs` (
  `id` int(255) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `id_question` int(255) NOT NULL,
  `id_survey` int(11) NOT NULL,
  `amount_answer` int(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `champs`
--

INSERT INTO `champs` (`id`, `reponse`, `id_question`, `id_survey`, `amount_answer`) VALUES
(1, 'Matt Smith', 3, 2, 2),
(3, 'David Tennant', 3, 2, 0),
(4, 'Peter Capaldi', 3, 2, 0),
(5, '1er Tardis', 4, 2, 9),
(6, 'Tardis de Clara', 4, 2, 4),
(7, 'Tardis du Maître', 4, 2, 2),
(9, 'Jonathan Joestar', 5, 5, 0),
(10, 'Joseph Joestar', 5, 5, 1),
(11, 'Jotaro Kujo', 5, 5, 0),
(12, 'Josuke Higashikata', 5, 5, 0),
(13, 'Giorno Giovanna', 5, 5, 0),
(14, 'Jolyne Cujoh', 5, 5, 0),
(15, 'oui', 6, 6, 1),
(16, 'non', 6, 6, 1),
(17, 'Johnny Joestar', 5, 5, 0),
(18, 'Josuke Higashikata', 5, 5, 0),
(26, 'Golden Wind', 8, 5, 0),
(20, 'Phantom Blood', 8, 5, 0),
(21, 'Bloody Stream', 8, 5, 0),
(22, 'Stardust Crusaders', 8, 5, 0),
(24, 'Diamond is Unbreakable', 8, 5, 1),
(27, 'Stone Ocean', 8, 5, 0),
(28, 'Steel Ball Run', 8, 5, 1),
(29, 'Jojolion', 8, 5, 0),
(30, 'eyrtujr', 10, 6, 1),
(31, 'tertytujhgtery', 10, 6, 1),
(53, 'yo', 22, 20, 1),
(52, 'ptdr tki ?', 22, 20, 0),
(38, 'Blanc', 14, 15, 2),
(51, 'yes', 22, 20, 0),
(49, '', 17, 18, 2),
(48, 'trgr', 17, 18, 0),
(47, 'rtth', 20, 19, 1),
(54, 'bien la mif ??', 22, 20, 0),
(55, 'trkl et toi gros ?', 23, 20, 1),
(56, 'pk tu me parles ?', 23, 20, 0),
(57, 'j\'suis pas ton pote, ok ?', 23, 20, 0),
(58, 'yes', 23, 20, 0),
(59, '', 25, 21, 1),
(75, 'yuk', 15, 15, 0),
(73, '2', 33, 27, 1),
(74, '3', 33, 27, 0),
(72, '1', 33, 27, 0),
(71, 'jioj', 14, 15, 0),
(76, 'sz', 15, 15, 1),
(79, 'ere', 47, 15, 0),
(80, 'ergegerg', 42, 15, 0),
(81, 'erge', 47, 15, 0),
(82, 'egergeg', 47, 15, 0),
(83, 'mohimbmjb', 32, 6, 0),
(84, 'lkb;,n ;,', 32, 6, 0);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `id_survey` int(255) NOT NULL,
  `optionnel` int(1) NOT NULL DEFAULT '0' COMMENT '0=non 1= oui',
  `choix` int(1) NOT NULL DEFAULT '0' COMMENT '0=choix multiple 1=choix simple',
  `total_r` int(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id`, `question`, `id_survey`, `optionnel`, `choix`, `total_r`) VALUES
(3, 'Quel est le meilleur des docteurs ?', 2, 1, 1, 2),
(4, 'Quel est le meilleur des Tardis ?', 2, 0, 0, 14),
(5, 'Qui est le meilleur Jojo ?', 5, 0, 0, 1),
(6, 'so no head ?', 6, 1, 0, 1),
(15, 'Ma vrai question ?', 15, 0, 0, 1),
(8, 'Quelle est la meilleure partie ?', 5, 0, 0, 1),
(10, 'qesrtyjgkhw', 6, 1, 0, 1),
(12, 'test', 14, 1, 0, 0),
(14, 'De quelle couleur est Margot ?', 15, 0, 0, 2),
(17, 'pokémon ?', 18, 1, 0, 4),
(21, 'uyk', 18, 1, 0, 0),
(19, 'reregr', 13, 1, 0, 0),
(20, '\'\"t\'\"t', 19, 1, 0, 1),
(22, 'Salut', 20, 0, 1, 1),
(23, 'Bien ou quoi ?', 20, 0, 0, 1),
(24, 'qlfdjqk', 20, 1, 0, 0),
(25, 'general Kenobi', 21, 1, 0, 1),
(34, 'k?', 28, 0, 0, 0),
(33, 'oui', 27, 0, 0, 1),
(32, 'zegdg', 6, 1, 0, 0),
(40, 'efgve', 15, 0, 0, 0),
(42, 'ergfeef', 15, 0, 0, 0),
(47, 'ergre', 15, 1, 0, 0),
(55, 'ergege', 43, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `survey`
--

CREATE TABLE `survey` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_owner` int(255) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '0=not finish, 1=finish'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `survey`
--

INSERT INTO `survey` (`id`, `name`, `id_owner`, `state`) VALUES
(2, 'Doctor who', 1, 0),
(3, 'qdsqdqdqs', 1, 0),
(5, 'Jojo\'s Bizarre Adventure', 3, 0),
(6, 'Omae wa mô shindeiru', 4, 0),
(8, 'est ce que typlo c\'est le plus beau ?', 6, 0),
(9, 'Gigazboub', 7, 0),
(11, 'test', 8, 0),
(13, 'ger', 9, 0),
(14, 'test', 10, 0),
(15, 'Margot', 5, 0),
(18, 'Pokémon', 5, 0),
(19, 'test', 9, 0),
(20, 'qkdmlkqsmldksqmldks', 12, 0),
(21, 'patapatate ?', 4, 0),
(26, 'f', 16, 0),
(27, 'rien', 13, 0),
(28, 'k', 17, 0),
(29, 'Panda2', 1, 0),
(30, 'qsdqds', 1, 0),
(31, 'qsqsdddqs', 1, 0),
(32, 'qqsqqssqqsqds', 1, 0),
(33, 'qsdqsdqsdqsdsq', 1, 0),
(34, 'qsdqdsqsd', 1, 0),
(35, 'qsdqds', 1, 0),
(36, 'qsdqdsq', 1, 0),
(37, 'qsdqsdqddqsd', 1, 0),
(38, 'qsdqdqdqssd', 1, 0),
(39, 'qsdqdqdsqsd', 1, 0),
(40, 'qsdqdqdqs', 1, 0),
(42, 'qsdqdsqd', 1, 0),
(43, 'erg', 5, 0),
(45, 'qsdqsd', 1, 0),
(46, 'qsdqsd', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `creation_date` date NOT NULL DEFAULT '2020-01-01',
  `abonnement` int(3) NOT NULL DEFAULT '0' COMMENT '0=None,1=Family,2=Prenium',
  `abonnement_date` date NOT NULL DEFAULT '2020-05-31'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `mail`, `creation_date`, `abonnement`, `abonnement_date`) VALUES
(1, 'Typlosion', '$2y$10$bvypJ97LTh4pAbpfu20Sxe0oYtM4K4mhUaBGLC044QSeeLGYe.5jG', 'pikachu.morgan@hotmail.fr', '2020-05-16', 0, '2020-06-13'),
(2, 'TestDate', '$2y$10$NMsunwqcnRqM0rh6CWhxIOX/yNDHbVzS//CL1MGY14wL6CoCArHaK', 'typlosiom@gmail.com', '2020-05-16', 0, '2020-05-31'),
(3, 'Jotier', '$2y$10$oc1dzsxB/o.cJS9ZKYZQUetINKzyt/XRHZQ5S2MnKnaHRlPyWzQra', '291739@supinfo.com', '2020-05-20', 1, '2020-06-11'),
(4, 'Patate', '$2y$10$6joO/LgpyLGqCRHLhWlQtOqFUyR24NRUBcnEmtFItArnOHlrKKgNC', 'lyderic.ogame@gmail.com', '2020-05-20', 2, '2020-06-13'),
(5, 'Artago', '$2y$10$0kVPddK.XE7lEt/ZV8yCye4dF/FcSB0jypS/t67mDZQHOoMpzdF66', 'artago.gm@gmail.com', '2020-05-20', 2, '2020-06-14'),
(6, 'Stormozz', '$2y$10$gKzVrXj9EpYbFtbnTtj9rujlLe8XQXNwfOPqPmkhxaodk4oZi7Vmm', 'blackwall124@gmail.com', '2020-05-20', 0, '2020-05-31'),
(7, 'grosziziquipue', '$2y$10$zUL6NTiG.p304QqORI.Z2Op52.DK3PSLGdUpZDmCfZthBk4xFTF/C', 'brieuc_leguern@yahoo.com', '2020-05-20', 0, '2020-05-31'),
(8, 'roxas', '$2y$10$qIOOntc.IuBPkcVldjIva.053gJZuRF3Lypa2pyolYFqoQJzRFYka', 'andrew.mahe14@gmail.com', '2020-05-24', 0, '2020-05-31'),
(9, 'ailvin', '$2y$10$N4Q4tWWzmHyET8MMbRIoCedPaCbChL2JEop4PsGR7oOmv/Zdna5Je', 'ailvin.carbon@supinfo.com', '2020-05-24', 1, '2020-06-11'),
(10, 'eee', '$2y$10$kXPHdlz8qWvUWF9VFIa9bO29IIty1zttmgY5T5IH4yno9YCJP1M1K', 'emilie.girard@aliceadsl.fr', '2020-06-04', 0, '2020-05-31'),
(11, 'macron', '$2y$10$TrUg/N8xXhIsX7dHosg7euQqJ5jKPGqgkgR27QO6HLbQfjqFLzC5C', 'artago.g@gmail.com', '2020-06-06', 0, '2020-05-31'),
(12, 'Pamplemouusse', '$2y$10$adt/aYNx4G.CgGUJpSnVwuMmxMfYysoB0.5ebCzHHKcdwIkD0FPyC', 'theogerard66@gmail.com', '2020-06-11', 1, '2020-06-11'),
(13, 'User', '$2y$10$11krLENJLRjOlx1vBzNS1eUibl4r5fdDb9i/ttKPhNSOu6upMtgIq', 'Email@example.com', '2020-06-11', 1, '2020-06-11'),
(14, 'POUAH', '$2y$10$3J0ZVmgfvO.GNOLhwbQmDOUB.Gr9flh3yOumyl1SBi.1W3M8X8I9C', 'maxime.fortnite@gmail.com', '2020-06-11', 0, '2020-05-31'),
(15, 'Lopolys', '$2y$10$ux/AlH98A53zhuAos8W9wuPC7mi/oBXZ0QzMX2.vgkmVXTcpSBLjq', 'popolyyyyyyyyyys@gmail.com', '2020-06-11', 0, '2020-05-31'),
(16, 'aaaaa', '$2y$10$RmJ42uJ2sog7d2CxhM04KeGQC7jtEwz9o.TVbtXweVmDvtgKJ6Z6W', 'jikolo.2.34.567@gmail.com', '2020-06-11', 0, '2020-05-31'),
(17, 'k', '$2y$10$DsECVaPUpz3hvg1MFIIDtOmHLGwGCIV6fAbdEVDXzk6P7FaOgJLAG', 'k@k.k', '2020-06-12', 0, '2020-05-31');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `champs`
--
ALTER TABLE `champs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`id_owner`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `champs`
--
ALTER TABLE `champs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `owner` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
