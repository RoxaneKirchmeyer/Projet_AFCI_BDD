-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : mer. 31 jan. 2024 à 11:44
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `afci`
--

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter` (
  `id_pedagogie` int NOT NULL,
  `id_centre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `apprenants`
--

CREATE TABLE `apprenants` (
  `id_apprenant` int NOT NULL,
  `nom_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mail_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ville_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_postal_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tel_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_naissance_apprenant` date DEFAULT NULL,
  `niveau_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_PE_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_secu_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rib_apprenant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_role` int DEFAULT NULL,
  `id_session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `apprenants`
--

INSERT INTO `apprenants` (`id_apprenant`, `nom_apprenant`, `prenom_apprenant`, `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`, `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`) VALUES
(1, 'Potter', 'Harry', 'hpotter@gmail.com', '4 Privet Drive', 'Surrey', '44444', '0000112', '1980-07-31', 'B.U.S.E', '01201200', '126545200', 'UK12452365', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `centres`
--

CREATE TABLE `centres` (
  `id_centre` int NOT NULL,
  `ville_centre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse_centre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_postal_centre` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `centres`
--

INSERT INTO `centres` (`id_centre`, `ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES
(1, 'Lille', '25 rue de la vague', '59000'),
(2, 'Lomme', '745 avenuce de dunkere', '59160');

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id_formation` int NOT NULL,
  `nom_formation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duree_formation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `niveau_sortie_formation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(1500) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id_formation`, `nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES
(1, 'DWWM', '9 mois', ' bac +2', 'Dev web');

-- --------------------------------------------------------

--
-- Structure de la table `localiser`
--

CREATE TABLE `localiser` (
  `id_formation` int NOT NULL,
  `id_centre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pedagogie`
--

CREATE TABLE `pedagogie` (
  `id_pedagogie` int NOT NULL,
  `nom_pedagogie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom_pedagogie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mail_pedagogie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_pedagogie` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pedagogie`
--

INSERT INTO `pedagogie` (`id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES
(1, 'Dumbledore', 'Albus', 'albus.dumbledore@poudlard.com', '10000000', 1),
(2, 'McGonagall', 'Minerva', 'minerva.mcgonagall@poudlard.com', '100000002', 2),
(3, 'Severus', 'Rogue', 'rogue.severus@poudlard.com', '100000003', 3);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `nom_role` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom_role`) VALUES
(1, 'Directeur'),
(2, 'Coordinateur'),
(3, 'Formateur'),
(4, 'Apprenant'),
(5, 'Inactif');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id_session` int NOT NULL,
  `nom_session` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_debut` date DEFAULT NULL,
  `id_centre` int NOT NULL,
  `id_pedagogie` int NOT NULL,
  `id_formation` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD PRIMARY KEY (`id_pedagogie`,`id_centre`),
  ADD KEY `FK_affecter_id_centre` (`id_centre`);

--
-- Index pour la table `apprenants`
--
ALTER TABLE `apprenants`
  ADD PRIMARY KEY (`id_apprenant`),
  ADD KEY `FK_apprenants_id_role` (`id_role`),
  ADD KEY `FK_apprenants_id_session` (`id_session`);

--
-- Index pour la table `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`id_centre`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_formation`);

--
-- Index pour la table `localiser`
--
ALTER TABLE `localiser`
  ADD PRIMARY KEY (`id_formation`,`id_centre`),
  ADD KEY `FK_localiser_id_centre` (`id_centre`);

--
-- Index pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  ADD PRIMARY KEY (`id_pedagogie`),
  ADD KEY `FK_pedagogie_id_role` (`id_role`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `FK_session_id_pedagogie` (`id_pedagogie`),
  ADD KEY `FK_session_id_formation` (`id_formation`),
  ADD KEY `FK_session_id_centre` (`id_centre`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affecter`
--
ALTER TABLE `affecter`
  MODIFY `id_pedagogie` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `apprenants`
--
ALTER TABLE `apprenants`
  MODIFY `id_apprenant` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `centres`
--
ALTER TABLE `centres`
  MODIFY `id_centre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_formation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `localiser`
--
ALTER TABLE `localiser`
  MODIFY `id_formation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  MODIFY `id_pedagogie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_affecter_id_centre` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id_centre`),
  ADD CONSTRAINT `FK_affecter_id_pedagogie` FOREIGN KEY (`id_pedagogie`) REFERENCES `pedagogie` (`id_pedagogie`);

--
-- Contraintes pour la table `apprenants`
--
ALTER TABLE `apprenants`
  ADD CONSTRAINT `FK_apprenants_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `FK_apprenants_id_session` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `localiser`
--
ALTER TABLE `localiser`
  ADD CONSTRAINT `FK_localiser_id_centre` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id_centre`),
  ADD CONSTRAINT `FK_localiser_id_formation` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`);

--
-- Contraintes pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  ADD CONSTRAINT `FK_pedagogie_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_session_id_centre` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id_centre`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_session_id_formation` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`),
  ADD CONSTRAINT `FK_session_id_pedagogie` FOREIGN KEY (`id_pedagogie`) REFERENCES `pedagogie` (`id_pedagogie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
