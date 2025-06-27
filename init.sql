-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 11 jan. 2024 à 20:30
-- Version du serveur : 10.3.38-MariaDB-0ubuntu0.20.04.1
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `AtDispo`
--
DROP DATABASE
    IF EXISTS AtDispo;
CREATE DATABASE AtDispo
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE AtDispo;

-- --------------------------------------------------------

--
-- Structure de la table `Acces`
--

CREATE TABLE `Acces` (
  `idCompte` int(11) NOT NULL,
  `idTypeCompte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Acces`
--

INSERT INTO `Acces` (`idCompte`, `idTypeCompte`) VALUES
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(7, 1),
(7, 2),
(7, 3),
(16, 1),
(16, 2),
(17, 1),
(18, 3),
(19, 2),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(22, 2),
(23, 3);

-- --------------------------------------------------------

--
-- Structure de la table `AffichagesTypesFermeture`
--

CREATE TABLE `AffichagesTypesFermeture` (
  `idAffichageTypeFermeture` int(11) NOT NULL,
  `affichageTypeFermeture` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `AffichagesTypesFermeture`
--

INSERT INTO `AffichagesTypesFermeture` (`idAffichageTypeFermeture`, `affichageTypeFermeture`) VALUES
(1, 'Congés'),
(2, 'Vacances Scolaire'),
(3, 'Fermeture');

-- --------------------------------------------------------

--
-- Structure de la table `CalendriersDisponibilite`
--

CREATE TABLE `CalendriersDisponibilite` (
  `idCalendrierDisponibilite` int(11) NOT NULL,
  `anneeScolCalendrierDisponibilite` varchar(20) NOT NULL,
  `dateMajEtat` date DEFAULT current_timestamp(),
  `idCompte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `CalendriersDisponibilite`
--

INSERT INTO `CalendriersDisponibilite` (`idCalendrierDisponibilite`, `anneeScolCalendrierDisponibilite`, `dateMajEtat`, `idCompte`) VALUES
(1, '2023-2024', '2023-11-01', 2),
(2, '2024-2025', '2024-03-08', 3),
(4, '2023-2024', '2023-12-14', 3),
(5, '2023-2024', '2024-01-03', 16),
(6, '2023-2024', '2024-01-10', 18);

-- --------------------------------------------------------

--
-- Structure de la table `Comptes`
--

CREATE TABLE `Comptes` (
  `idCompte` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `courriel` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `idOrganismeFormation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Comptes`
--

INSERT INTO `Comptes` (`idCompte`, `nom`, `prenom`, `courriel`, `password`, `idOrganismeFormation`) VALUES
(1, 'super', 'super', 'enzo@gmail.com', '$2y$10$9pusjVQetxhSQOo/khHt7eXJ.p5bKB1TdylKoJgMzSf17Ox99yu7K', NULL),
(2, 'nomUser1', 'prénomUser1', 'test1@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', 1),
(3, 'nomUser2', 'prénomUser2', 'test2@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', 2),
(7, 'nomUser3', 'prénomUser3', 'test3@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', 5),
(16, 'nomUser4', 'prénomUser4', 'test4@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(17, 'nomUser5', 'prénomUser5', 'test5@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(18, 'nomUser6', 'prénomUser6', 'test6@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(19, 'nomUser7', 'prénomUser7', 'test7@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', 1),
(20, 'nomUser8', 'prénomUser8', 'test8@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(21, 'nomUser9', 'prénomUser9', 'test9@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(22, 'nomUser10', 'prénomUser10', 'test10@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL),
(23, 'nomUser11', 'prénomUser11', 'test11@test.com', '$2y$10$yxIbFSODcRhnq1Qzi5T7T.Y.R/vDKUHtSRxJdHAMSGYjBuVrJ7YWy', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Contenus`
--

CREATE TABLE `Contenus` (
  `idNomFormation` int(11) NOT NULL,
  `idMatiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Contenus`
--

INSERT INTO `Contenus` (`idNomFormation`, `idMatiere`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(4, 9);

-- --------------------------------------------------------

--
-- Structure de la table `CreneauDisponibilite`
--

CREATE TABLE `CreneauDisponibilite` (
  `idCreneauDisponibilite` int(11) NOT NULL,
  `dateCreneauDisponibilite` date NOT NULL,
  `idMatiere` int(11) DEFAULT NULL,
  `idFormation` int(11) DEFAULT NULL,
  `idCalendrierDisponibilite` int(11) NOT NULL,
  `idEtatDisponibilite` int(11) NOT NULL,
  `idTypeCreneau` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `CreneauDisponibilite`
--

INSERT INTO `CreneauDisponibilite` (`idCreneauDisponibilite`, `dateCreneauDisponibilite`, `idMatiere`, `idFormation`, `idCalendrierDisponibilite`, `idEtatDisponibilite`, `idTypeCreneau`) VALUES
(1, '2023-11-09', 6, NULL, 1, 1, 1),
(2, '2024-03-09', 5, NULL, 1, 3, 1),
(3, '2023-11-02', 3, NULL, 1, 1, 2),
(20, '2023-08-07', NULL, NULL, 5, 2, 1),
(22, '2023-08-07', NULL, NULL, 5, 1, 2),
(23, '2023-08-09', NULL, NULL, 5, 1, 2),
(24, '2023-08-08', NULL, NULL, 5, 4, 1),
(25, '2023-08-08', NULL, NULL, 5, 4, 2),
(26, '2023-08-01', NULL, NULL, 4, 1, 1),
(27, '2023-08-01', NULL, NULL, 4, 1, 2),
(28, '2023-08-02', NULL, NULL, 4, 1, 1),
(29, '2023-08-02', NULL, NULL, 4, 1, 2),
(30, '2023-08-03', NULL, NULL, 4, 1, 1),
(31, '2023-08-03', NULL, NULL, 4, 1, 2),
(32, '2023-08-04', NULL, NULL, 4, 1, 1),
(33, '2023-08-04', NULL, NULL, 4, 1, 2),
(34, '2023-08-07', NULL, NULL, 4, 2, 1),
(35, '2023-08-07', NULL, NULL, 4, 2, 2),
(36, '2023-08-08', NULL, NULL, 4, 2, 1),
(37, '2023-08-08', NULL, NULL, 4, 2, 2),
(38, '2023-08-09', NULL, NULL, 4, 2, 1),
(39, '2023-08-09', NULL, NULL, 4, 2, 2),
(40, '2023-08-10', NULL, NULL, 4, 4, 1),
(41, '2023-08-10', NULL, NULL, 4, 2, 2),
(42, '2023-08-11', NULL, NULL, 4, 4, 1),
(43, '2023-08-11', NULL, NULL, 4, 4, 2),
(44, '2023-08-14', NULL, NULL, 4, 4, 1),
(45, '2023-08-14', NULL, NULL, 4, 4, 2),
(46, '2023-08-15', NULL, NULL, 4, 4, 1),
(47, '2023-08-15', NULL, NULL, 4, 4, 2),
(48, '2023-08-16', NULL, NULL, 4, 4, 1),
(49, '2023-08-16', NULL, NULL, 4, 4, 2),
(50, '2023-08-17', NULL, NULL, 4, 4, 1),
(51, '2023-08-17', NULL, NULL, 4, 4, 2),
(52, '2023-08-01', 4, 3, 6, 5, 1),
(53, '2023-08-01', NULL, NULL, 6, 2, 2),
(54, '2023-08-02', NULL, NULL, 6, 4, 1),
(55, '2023-08-03', 4, 16, 6, 5, 1),
(56, '2023-08-03', NULL, NULL, 6, 2, 2),
(57, '2023-08-04', NULL, NULL, 6, 4, 1),
(58, '2023-08-04', NULL, NULL, 6, 1, 2),
(59, '2023-08-08', NULL, NULL, 6, 4, 2),
(60, '2023-08-01', NULL, NULL, 1, 1, 1),
(61, '2023-08-01', NULL, NULL, 1, 1, 2),
(62, '2023-08-02', NULL, NULL, 1, 1, 1),
(63, '2023-08-02', NULL, NULL, 1, 1, 2),
(64, '2023-08-03', NULL, NULL, 1, 1, 1),
(65, '2023-08-03', NULL, NULL, 1, 1, 2),
(66, '2023-08-04', NULL, NULL, 1, 2, 1),
(67, '2023-08-04', NULL, NULL, 1, 2, 2),
(68, '2023-08-07', NULL, NULL, 1, 1, 1),
(69, '2023-08-07', NULL, NULL, 1, 2, 2),
(70, '2023-08-08', NULL, NULL, 1, 1, 1),
(71, '2023-08-08', NULL, NULL, 1, 1, 2),
(72, '2023-08-09', NULL, NULL, 1, 1, 1),
(73, '2023-08-09', NULL, NULL, 1, 1, 2),
(74, '2023-08-10', NULL, NULL, 1, 1, 1),
(75, '2023-08-10', NULL, NULL, 1, 2, 2),
(76, '2023-08-11', NULL, NULL, 1, 2, 1),
(77, '2023-08-11', NULL, NULL, 1, 2, 2),
(78, '2023-08-14', NULL, NULL, 1, 1, 1),
(79, '2023-08-14', NULL, NULL, 1, 4, 2),
(80, '2023-08-15', NULL, NULL, 1, 4, 1),
(81, '2023-08-15', NULL, NULL, 1, 1, 2),
(82, '2023-08-16', NULL, NULL, 1, 1, 1),
(83, '2023-08-16', NULL, NULL, 1, 1, 2),
(84, '2023-08-17', NULL, NULL, 1, 4, 1),
(85, '2023-08-17', NULL, NULL, 1, 4, 2),
(86, '2023-08-18', NULL, NULL, 1, 2, 1),
(87, '2023-08-18', NULL, NULL, 1, 2, 2),
(88, '2023-08-21', NULL, NULL, 1, 1, 1),
(89, '2023-08-21', NULL, NULL, 1, 1, 2),
(90, '2023-08-22', NULL, NULL, 1, 2, 1),
(91, '2023-08-22', NULL, NULL, 1, 2, 2),
(92, '2023-08-23', NULL, NULL, 1, 4, 1),
(93, '2023-08-23', NULL, NULL, 1, 1, 2),
(94, '2023-08-24', NULL, NULL, 1, 2, 1),
(95, '2023-08-24', NULL, NULL, 1, 1, 2),
(96, '2023-08-25', NULL, NULL, 1, 1, 1),
(97, '2023-08-25', NULL, NULL, 1, 2, 2),
(98, '2023-08-28', NULL, NULL, 1, 1, 1),
(99, '2023-08-28', NULL, NULL, 1, 1, 2),
(100, '2023-08-29', NULL, NULL, 1, 4, 1),
(101, '2023-08-29', NULL, NULL, 1, 1, 2),
(102, '2023-08-30', NULL, NULL, 1, 1, 1),
(103, '2023-08-30', NULL, NULL, 1, 2, 2),
(104, '2023-08-31', NULL, NULL, 1, 2, 1),
(105, '2023-08-31', NULL, NULL, 1, 1, 2),
(106, '2023-09-01', NULL, NULL, 1, 4, 1),
(107, '2023-09-01', NULL, NULL, 1, 1, 2),
(108, '2024-07-01', NULL, NULL, 1, 1, 1),
(109, '2024-07-01', NULL, NULL, 1, 1, 2),
(110, '2024-07-02', NULL, NULL, 1, 2, 1),
(111, '2024-07-02', NULL, NULL, 1, 1, 2),
(112, '2024-07-03', NULL, NULL, 1, 2, 1),
(113, '2024-07-03', NULL, NULL, 1, 4, 2),
(114, '2024-07-04', NULL, NULL, 1, 1, 1),
(115, '2024-07-04', NULL, NULL, 1, 1, 2),
(116, '2024-07-05', NULL, NULL, 1, 1, 1),
(117, '2024-07-05', NULL, NULL, 1, 1, 2),
(118, '2024-07-08', NULL, NULL, 1, 1, 1),
(119, '2024-07-08', NULL, NULL, 1, 4, 2),
(120, '2024-07-09', NULL, NULL, 1, 4, 1),
(121, '2024-07-09', NULL, NULL, 1, 1, 2),
(122, '2024-07-10', NULL, NULL, 1, 2, 1),
(123, '2024-07-10', NULL, NULL, 1, 2, 2),
(124, '2024-07-11', NULL, NULL, 1, 1, 1),
(125, '2024-07-11', NULL, NULL, 1, 1, 2),
(126, '2024-07-12', NULL, NULL, 1, 1, 1),
(127, '2024-07-12', NULL, NULL, 1, 1, 2),
(128, '2024-07-15', NULL, NULL, 1, 1, 1),
(129, '2024-07-15', NULL, NULL, 1, 1, 2),
(130, '2024-07-16', NULL, NULL, 1, 1, 1),
(131, '2024-07-16', NULL, NULL, 1, 1, 2),
(132, '2024-07-17', NULL, NULL, 1, 1, 1),
(133, '2024-07-17', NULL, NULL, 1, 1, 2),
(134, '2024-07-18', NULL, NULL, 1, 1, 1),
(135, '2024-07-18', NULL, NULL, 1, 1, 2),
(136, '2024-07-19', NULL, NULL, 1, 1, 1),
(137, '2024-07-19', NULL, NULL, 1, 1, 2),
(138, '2024-07-22', NULL, NULL, 1, 1, 1),
(139, '2024-07-22', NULL, NULL, 1, 1, 2),
(140, '2024-07-23', NULL, NULL, 1, 4, 1),
(141, '2024-07-23', NULL, NULL, 1, 4, 2),
(142, '2024-07-24', NULL, NULL, 1, 1, 1),
(143, '2024-07-24', NULL, NULL, 1, 2, 2),
(144, '2024-07-25', NULL, NULL, 1, 2, 1),
(145, '2024-07-25', NULL, NULL, 1, 1, 2),
(146, '2024-07-26', NULL, NULL, 1, 2, 1),
(147, '2024-07-26', NULL, NULL, 1, 1, 2),
(148, '2024-07-29', NULL, NULL, 1, 1, 1),
(149, '2024-07-29', NULL, NULL, 1, 1, 2),
(150, '2024-07-30', NULL, NULL, 1, 4, 1),
(151, '2024-07-30', NULL, NULL, 1, 4, 2),
(152, '2024-07-31', NULL, NULL, 1, 2, 1),
(153, '2024-07-31', NULL, NULL, 1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `DisposIntervenant`
--

CREATE TABLE `DisposIntervenant` (
  `idCompte` int(11) NOT NULL,
  `idCalendrierDisponibilite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `DisposIntervenant`
--

INSERT INTO `DisposIntervenant` (`idCompte`, `idCalendrierDisponibilite`) VALUES
(2, 1),
(3, 2),
(19, 6);

-- --------------------------------------------------------

--
-- Structure de la table `EtatsDisponibilite`
--

CREATE TABLE `EtatsDisponibilite` (
  `idEtatDisponibilite` int(11) NOT NULL,
  `libelleEtatDisponibilite` varchar(30) NOT NULL,
  `couleurEtatDisponibilite` char(7) NOT NULL DEFAULT '#FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `EtatsDisponibilite`
--

INSERT INTO `EtatsDisponibilite` (`idEtatDisponibilite`, `libelleEtatDisponibilite`, `couleurEtatDisponibilite`) VALUES
(1, 'Disponible', '#20c997'),
(2, 'Pas Disponible', '#dc3545'),
(3, 'Indéfini', '#939393'),
(4, 'Potentiellement Dispo', '#ffa33c'),
(5, 'En attente', '#ebff00');

-- --------------------------------------------------------

--
-- Structure de la table `Fermeture`
--

CREATE TABLE `Fermeture` (
  `idFermeture` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idTypeFermeture` int(11) NOT NULL,
  `idNomFermeture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Fermeture`
--

INSERT INTO `Fermeture` (`idFermeture`, `dateDebut`, `dateFin`, `idTypeFermeture`, `idNomFermeture`) VALUES
(1, '2023-11-01', '2023-11-04', 4, 1),
(2, '2023-11-15', '2023-11-30', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Formations`
--

CREATE TABLE `Formations` (
  `idFormation` int(11) NOT NULL,
  `dateDebutFormation` date NOT NULL,
  `dateFinFormation` date NOT NULL,
  `idNomFormation` int(11) NOT NULL,
  `idSiteOrgaFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Formations`
--

INSERT INTO `Formations` (`idFormation`, `dateDebutFormation`, `dateFinFormation`, `idNomFormation`, `idSiteOrgaFormation`) VALUES
(1, '2023-11-01', '2023-11-30', 3, 1),
(2, '2024-03-07', '2024-06-20', 3, 2),
(3, '2023-11-01', '2024-08-01', 4, 1),
(4, '2023-11-01', '2024-05-02', 5, 1),
(5, '2023-11-01', '2024-06-01', 5, 2),
(6, '2023-11-01', '2024-08-01', 5, 3),
(8, '2024-04-04', '2024-04-30', 6, 4),
(9, '2023-11-02', '2024-03-16', 9, 4),
(10, '2023-11-01', '2023-11-30', 10, 4),
(12, '2023-12-01', '2023-12-31', 8, 4),
(13, '2023-11-01', '2024-04-26', 7, 4),
(14, '2023-12-05', '2023-12-29', 3, 3),
(15, '2023-12-01', '2023-12-31', 3, 3),
(16, '2023-12-12', '2023-12-29', 4, 1),
(18, '2023-12-04', '2023-12-29', 3, 3),
(20, '2024-01-02', '2024-01-26', 6, 4),
(23, '2024-01-03', '2024-05-17', 4, 4),
(24, '2023-09-01', '2024-07-01', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Matieres`
--

CREATE TABLE `Matieres` (
  `idMatiere` int(11) NOT NULL,
  `libelleMatiere` varchar(30) NOT NULL,
  `valide` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Matieres`
--

INSERT INTO `Matieres` (`idMatiere`, `libelleMatiere`, `valide`) VALUES
(1, 'Math - Algo', 1),
(2, 'Anglais', 1),
(3, 'Allemand', 1),
(4, 'Cybersecurite', 1),
(5, 'Cours Php', 1),
(6, 'SQL', 1),
(7, 'Ingénierie Logicielle ', 1),
(8, 'Gouvernance & Orga des SI', 1),
(9, 'Développement Perso & Pro', 1);

-- --------------------------------------------------------

--
-- Structure de la table `NomsFermeture`
--

CREATE TABLE `NomsFermeture` (
  `idNomFermeture` int(11) NOT NULL,
  `libelleNomFermeture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `NomsFermeture`
--

INSERT INTO `NomsFermeture` (`idNomFermeture`, `libelleNomFermeture`) VALUES
(1, 'jsp woulah'),
(2, 'jsp woulah 2'),
(3, 'jsp woulah 3'),
(4, 'frr flemme de réfléchir ');

-- --------------------------------------------------------

--
-- Structure de la table `NomsFormation`
--

CREATE TABLE `NomsFormation` (
  `idNomFormation` int(11) NOT NULL,
  `valide` tinyint(1) DEFAULT 0,
  `libelleNomFormation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `NomsFormation`
--

INSERT INTO `NomsFormation` (`idNomFormation`, `valide`, `libelleNomFormation`) VALUES
(3, 1, 'BTS SIO'),
(4, 1, 'BTS M2I'),
(5, 1, 'BTS NDRC'),
(6, 1, 'License RQE'),
(7, 1, 'LP MIC2'),
(8, 1, 'LP CSE'),
(9, 1, 'LP Projet Web'),
(10, 1, 'LP Info Général'),
(11, 0, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `OptionsFormation`
--

CREATE TABLE `OptionsFormation` (
  `idOptionFormation` int(11) NOT NULL,
  `valide` tinyint(1) DEFAULT 0,
  `libelleNomOptionFormation` varchar(20) NOT NULL,
  `idNomFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `OptionsFormation`
--

INSERT INTO `OptionsFormation` (`idOptionFormation`, `valide`, `libelleNomOptionFormation`, `idNomFormation`) VALUES
(1, 1, 'SLAM', 3),
(3, 1, 'SISR', 3),
(4, 1, 'Exp. DevelopementT', 4),
(5, 1, 'Sécurite & Cloud', 4),
(7, 1, 'Option n1', 4),
(24, 1, 'OptionsRQE1', 6),
(25, 1, 'OptionsRQE2', 6);

-- --------------------------------------------------------

--
-- Structure de la table `OrganismesFormation`
--

CREATE TABLE `OrganismesFormation` (
  `idOrganismeFormation` int(11) NOT NULL,
  `nomOrganismeFormation` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` char(5) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `valide` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `OrganismesFormation`
--

INSERT INTO `OrganismesFormation` (`idOrganismeFormation`, `nomOrganismeFormation`, `adresse`, `codePostal`, `ville`, `valide`) VALUES
(1, 'CCI Campus Alsace', '234 Av. de Colmar, 67021 Strasbourg', '67000', 'Strasbourg', 1),
(2, 'CCI Region Paris Ile France', '2 Bd Blaise Pascal', '93160', 'Noisy-le-Grand', 1),
(5, 'CCI Formation Aix-Marseille-Provence', '1 Rue Saint-Sébastien', '13006', 'Marseille', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ProposeOption`
--

CREATE TABLE `ProposeOption` (
  `idOptionFormation` int(11) NOT NULL,
  `idFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ProposeOption`
--

INSERT INTO `ProposeOption` (`idOptionFormation`, `idFormation`) VALUES
(1, 1),
(1, 15),
(1, 24),
(3, 1),
(3, 15),
(3, 24),
(4, 5),
(5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `SitesOrgaFormation`
--

CREATE TABLE `SitesOrgaFormation` (
  `idSiteOrgaFormation` int(11) NOT NULL,
  `nomSiteOrgaFormation` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` char(5) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `idOrganismeFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `SitesOrgaFormation`
--

INSERT INTO `SitesOrgaFormation` (`idSiteOrgaFormation`, `nomSiteOrgaFormation`, `adresse`, `codePostal`, `ville`, `idOrganismeFormation`) VALUES
(1, 'CCI Campus - Strasbourg', '234 Av. de Colmar', '67000', 'Strasbourg', 1),
(2, 'CCI Campus - Colmar', '4 Rue du Rhin', '68000', 'Colmar', 1),
(3, 'CCI Campus - Mulhouse', '15 Rue des Frères Lumière', '68350', 'Mulhouse', 1),
(4, 'CCI Region Paris Ile France', '27 Av. de Friedland', '75000', 'Paris Ile France', 2);

-- --------------------------------------------------------

--
-- Structure de la table `TokenForgetPassword`
--

CREATE TABLE `TokenForgetPassword` (
  `idToken` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `idUser` int(11) NOT NULL,
  `validationDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `TypesCompte`
--

CREATE TABLE `TypesCompte` (
  `idTypeCompte` int(11) NOT NULL,
  `libelleTypeCompte` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TypesCompte`
--

INSERT INTO `TypesCompte` (`idTypeCompte`, `libelleTypeCompte`) VALUES
(1, 'Administrateur'),
(2, 'Responsable'),
(3, 'Formateur'),
(4, 'SuperAdmin');

-- --------------------------------------------------------

--
-- Structure de la table `TypesCreneau`
--

CREATE TABLE `TypesCreneau` (
  `idTypeCreneau` int(11) NOT NULL,
  `libelleTypeCreneau` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TypesCreneau`
--

INSERT INTO `TypesCreneau` (`idTypeCreneau`, `libelleTypeCreneau`) VALUES
(1, 'matin'),
(2, 'apres-midi');

-- --------------------------------------------------------

--
-- Structure de la table `TypesFermeture`
--

CREATE TABLE `TypesFermeture` (
  `idTypeFermeture` int(11) NOT NULL,
  `libelleTypeFermeture` varchar(50) NOT NULL,
  `couleurTypeFermeture` char(7) NOT NULL DEFAULT '#FFFFFF',
  `idAffichageTypeFermeture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TypesFermeture`
--

INSERT INTO `TypesFermeture` (`idTypeFermeture`, `libelleTypeFermeture`, `couleurTypeFermeture`, `idAffichageTypeFermeture`) VALUES
(1, 'Noel', '#FFFFFF', 2),
(2, 'Toussaint', '#FFFFFF', 2),
(3, 'Météo', '#000CCC', 3),
(4, 'Perso', '#CAF232', 1),
(5, 'Été', '#FFFFFF', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Acces`
--
ALTER TABLE `Acces`
  ADD PRIMARY KEY (`idCompte`,`idTypeCompte`),
  ADD KEY `idTypeCompte` (`idTypeCompte`);

--
-- Index pour la table `AffichagesTypesFermeture`
--
ALTER TABLE `AffichagesTypesFermeture`
  ADD PRIMARY KEY (`idAffichageTypeFermeture`);

--
-- Index pour la table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  ADD PRIMARY KEY (`idCalendrierDisponibilite`),
  ADD KEY `idCompte` (`idCompte`);

--
-- Index pour la table `Comptes`
--
ALTER TABLE `Comptes`
  ADD PRIMARY KEY (`idCompte`),
  ADD KEY `idOrganismeFormation` (`idOrganismeFormation`);

--
-- Index pour la table `Contenus`
--
ALTER TABLE `Contenus`
  ADD PRIMARY KEY (`idNomFormation`,`idMatiere`),
  ADD KEY `idMatiere` (`idMatiere`);

--
-- Index pour la table `CreneauDisponibilite`
--
ALTER TABLE `CreneauDisponibilite`
  ADD PRIMARY KEY (`idCreneauDisponibilite`),
  ADD UNIQUE KEY `dateCreneauDisponibilite` (`dateCreneauDisponibilite`,`idCalendrierDisponibilite`,`idTypeCreneau`) USING BTREE,
  ADD KEY `idFormation` (`idFormation`),
  ADD KEY `idCalendrierDisponibilite` (`idCalendrierDisponibilite`),
  ADD KEY `idEtatDisponibilite` (`idEtatDisponibilite`),
  ADD KEY `idTypeCreneau` (`idTypeCreneau`),
  ADD KEY `idMatiere` (`idMatiere`) USING BTREE;

--
-- Index pour la table `DisposIntervenant`
--
ALTER TABLE `DisposIntervenant`
  ADD PRIMARY KEY (`idCompte`,`idCalendrierDisponibilite`),
  ADD KEY `idCalendrierDisponibilite` (`idCalendrierDisponibilite`);

--
-- Index pour la table `EtatsDisponibilite`
--
ALTER TABLE `EtatsDisponibilite`
  ADD PRIMARY KEY (`idEtatDisponibilite`);

--
-- Index pour la table `Fermeture`
--
ALTER TABLE `Fermeture`
  ADD PRIMARY KEY (`idFermeture`),
  ADD KEY `idTypeFermeture` (`idTypeFermeture`),
  ADD KEY `idNomFermeture` (`idNomFermeture`);

--
-- Index pour la table `Formations`
--
ALTER TABLE `Formations`
  ADD PRIMARY KEY (`idFormation`),
  ADD KEY `idNomFormation` (`idNomFormation`),
  ADD KEY `idSiteOrgaFormation` (`idSiteOrgaFormation`);

--
-- Index pour la table `Matieres`
--
ALTER TABLE `Matieres`
  ADD PRIMARY KEY (`idMatiere`);

--
-- Index pour la table `NomsFermeture`
--
ALTER TABLE `NomsFermeture`
  ADD PRIMARY KEY (`idNomFermeture`);

--
-- Index pour la table `NomsFormation`
--
ALTER TABLE `NomsFormation`
  ADD PRIMARY KEY (`idNomFormation`);

--
-- Index pour la table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  ADD PRIMARY KEY (`idOptionFormation`),
  ADD KEY `idNomFormation` (`idNomFormation`);

--
-- Index pour la table `OrganismesFormation`
--
ALTER TABLE `OrganismesFormation`
  ADD PRIMARY KEY (`idOrganismeFormation`);

--
-- Index pour la table `ProposeOption`
--
ALTER TABLE `ProposeOption`
  ADD PRIMARY KEY (`idOptionFormation`,`idFormation`),
  ADD KEY `idFormation` (`idFormation`);

--
-- Index pour la table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  ADD PRIMARY KEY (`idSiteOrgaFormation`),
  ADD KEY `idOrganismeFormation` (`idOrganismeFormation`);

--
-- Index pour la table `TokenForgetPassword`
--
ALTER TABLE `TokenForgetPassword`
  ADD PRIMARY KEY (`idToken`);

--
-- Index pour la table `TypesCompte`
--
ALTER TABLE `TypesCompte`
  ADD PRIMARY KEY (`idTypeCompte`);

--
-- Index pour la table `TypesCreneau`
--
ALTER TABLE `TypesCreneau`
  ADD PRIMARY KEY (`idTypeCreneau`);

--
-- Index pour la table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  ADD PRIMARY KEY (`idTypeFermeture`),
  ADD KEY `idAffichageTypeFermeture` (`idAffichageTypeFermeture`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `AffichagesTypesFermeture`
--
ALTER TABLE `AffichagesTypesFermeture`
  MODIFY `idAffichageTypeFermeture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  MODIFY `idCalendrierDisponibilite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Comptes`
--
ALTER TABLE `Comptes`
  MODIFY `idCompte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `CreneauDisponibilite`
--
ALTER TABLE `CreneauDisponibilite`
  MODIFY `idCreneauDisponibilite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT pour la table `EtatsDisponibilite`
--
ALTER TABLE `EtatsDisponibilite`
  MODIFY `idEtatDisponibilite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Fermeture`
--
ALTER TABLE `Fermeture`
  MODIFY `idFermeture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Formations`
--
ALTER TABLE `Formations`
  MODIFY `idFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `Matieres`
--
ALTER TABLE `Matieres`
  MODIFY `idMatiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `NomsFermeture`
--
ALTER TABLE `NomsFermeture`
  MODIFY `idNomFermeture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `NomsFormation`
--
ALTER TABLE `NomsFormation`
  MODIFY `idNomFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  MODIFY `idOptionFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `OrganismesFormation`
--
ALTER TABLE `OrganismesFormation`
  MODIFY `idOrganismeFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  MODIFY `idSiteOrgaFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `TokenForgetPassword`
--
ALTER TABLE `TokenForgetPassword`
  MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `TypesCompte`
--
ALTER TABLE `TypesCompte`
  MODIFY `idTypeCompte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `TypesCreneau`
--
ALTER TABLE `TypesCreneau`
  MODIFY `idTypeCreneau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  MODIFY `idTypeFermeture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Acces`
--
ALTER TABLE `Acces`
  ADD CONSTRAINT `Acces_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Acces_ibfk_2` FOREIGN KEY (`idTypeCompte`) REFERENCES `TypesCompte` (`idTypeCompte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  ADD CONSTRAINT `CalendriersDisponibilite_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Comptes`
--
ALTER TABLE `Comptes`
  ADD CONSTRAINT `Comptes_ibfk_1` FOREIGN KEY (`idOrganismeFormation`) REFERENCES `OrganismesFormation` (`idOrganismeFormation`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `Contenus`
--
ALTER TABLE `Contenus`
  ADD CONSTRAINT `idMatiere` FOREIGN KEY (`idMatiere`) REFERENCES `Matieres` (`idMatiere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idNomFormation` FOREIGN KEY (`idNomFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `CreneauDisponibilite`
--
ALTER TABLE `CreneauDisponibilite`
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_1` FOREIGN KEY (`idMatiere`) REFERENCES `Matieres` (`idMatiere`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_2` FOREIGN KEY (`idFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_3` FOREIGN KEY (`idCalendrierDisponibilite`) REFERENCES `CalendriersDisponibilite` (`idCalendrierDisponibilite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_5` FOREIGN KEY (`idTypeCreneau`) REFERENCES `TypesCreneau` (`idTypeCreneau`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `DisposIntervenant`
--
ALTER TABLE `DisposIntervenant`
  ADD CONSTRAINT `DisposIntervenant_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `DisposIntervenant_ibfk_2` FOREIGN KEY (`idCalendrierDisponibilite`) REFERENCES `CalendriersDisponibilite` (`idCalendrierDisponibilite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Fermeture`
--
ALTER TABLE `Fermeture`
  ADD CONSTRAINT `Fermeture_ibfk_1` FOREIGN KEY (`idTypeFermeture`) REFERENCES `TypesFermeture` (`idTypeFermeture`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fermeture_ibfk_2` FOREIGN KEY (`idNomFermeture`) REFERENCES `NomsFermeture` (`idNomFermeture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Formations`
--
ALTER TABLE `Formations`
  ADD CONSTRAINT `Formations_ibfk_2` FOREIGN KEY (`idSiteOrgaFormation`) REFERENCES `SitesOrgaFormation` (`idSiteOrgaFormation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Formations_idformatio` FOREIGN KEY (`idNomFormation`) REFERENCES `NomsFormation` (`idNomFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  ADD CONSTRAINT `OptionsFormation_ibfk_1` FOREIGN KEY (`idNomFormation`) REFERENCES `NomsFormation` (`idNomFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProposeOption`
--
ALTER TABLE `ProposeOption`
  ADD CONSTRAINT `ProposeOption_ibfk_1` FOREIGN KEY (`idOptionFormation`) REFERENCES `OptionsFormation` (`idOptionFormation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProposeOption_ibfk_2` FOREIGN KEY (`idFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  ADD CONSTRAINT `SitesOrgaFormation_ibfk_1` FOREIGN KEY (`idOrganismeFormation`) REFERENCES `OrganismesFormation` (`idOrganismeFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  ADD CONSTRAINT `TypesFermeture_ibfk_1` FOREIGN KEY (`idAffichageTypeFermeture`) REFERENCES `AffichagesTypesFermeture` (`idAffichageTypeFermeture`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
