-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2023 at 12:39 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE AtDispo
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE AtDispo;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AtDispo`
--

-- --------------------------------------------------------

--
-- Table structure for table `Acces`
--

CREATE TABLE `Acces` (
  `idCompte` int(11) NOT NULL,
  `idTypeCompte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AffichagesTypesFermeture`
--

CREATE TABLE `AffichagesTypesFermeture` (
  `idAffichageTypeFermeture` int(11) NOT NULL,
  `affichageTypeFermeture` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CalendriersDisponibilite`
--

CREATE TABLE `CalendriersDisponibilite` (
  `idCalendrierDisponibilite` int(11) NOT NULL,
  `anneeScolCalendrierDisponibilite` varchar(20) NOT NULL,
  `dateMajEtat` date DEFAULT current_timestamp(),
  `idCompte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Comptes`
--

CREATE TABLE `Comptes` (
  `idCompte` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `courriel` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `idOrganismeFormation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Contenus`
--

CREATE TABLE `Contenus` (
  `idNomFormation` int(11) NOT NULL,
  `idMatiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CreneauDisponibilite`
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

-- --------------------------------------------------------

--
-- Table structure for table `DisposIntervenant`
--

CREATE TABLE `DisposIntervenant` (
  `idCompte` int(11) NOT NULL,
  `idCalendrierDisponibilite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EtatsDisponibilite`
--

CREATE TABLE `EtatsDisponibilite` (
  `idEtatDisponibilite` int(11) NOT NULL,
  `libelleEtatDisponibilite` varchar(30) NOT NULL,
  `couleurEtatDisponibilite` char(7) NOT NULL DEFAULT '#FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Fermeture`
--

CREATE TABLE `Fermeture` (
  `idFermeture` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idTypeFermeture` int(11) NOT NULL,
  `idNomFermeture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Formations`
--

CREATE TABLE `Formations` (
  `idFormation` int(11) NOT NULL,
  `dateDebutFormation` date NOT NULL,
  `dateFinFormation` date NOT NULL,
  `idNomFormation` int(11) NOT NULL,
  `idSiteOrgaFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Matieres`
--

CREATE TABLE `Matieres` (
  `idMatiere` int(11) NOT NULL,
  `libelleMatiere` varchar(30) NOT NULL,
  `valide` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NomsFermeture`
--

CREATE TABLE `NomsFermeture` (
  `idNomFermeture` int(11) NOT NULL,
  `libelleNomFermeture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NomsFormation`
--

CREATE TABLE `NomsFormation` (
  `idNomFormation` int(11) NOT NULL,
  `valide` tinyint(1) DEFAULT 0,
  `libelleNomFormation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OptionsFormation`
--

CREATE TABLE `OptionsFormation` (
  `idOptionFormation` int(11) NOT NULL,
  `valide` tinyint(1) DEFAULT 0,
  `libelleNomOptionFormation` varchar(20) NOT NULL,
  `idNomFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OrganismesFormation`
--

CREATE TABLE `OrganismesFormation` (
  `idOrganismeFormation` int(11) NOT NULL,
  `nomOrganismeFormation` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` char(5) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `valide` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProposeOption`
--

CREATE TABLE `ProposeOption` (
  `idOptionFormation` int(11) NOT NULL,
  `idFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SitesOrgaFormation`
--

CREATE TABLE `SitesOrgaFormation` (
  `idSiteOrgaFormation` int(11) NOT NULL,
  `nomSiteOrgaFormation` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codePostal` char(5) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `idOrganismeFormation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TokenForgetPassword`
--

CREATE TABLE `TokenForgetPassword` (
  `idToken` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `idUser` int(11) NOT NULL,
  `validationDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TypesCompte`
--

CREATE TABLE `TypesCompte` (
  `idTypeCompte` int(11) NOT NULL,
  `libelleTypeCompte` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `TypesCompte`
--

INSERT INTO `TypesCompte` (`idTypeCompte`, `libelleTypeCompte`) VALUES
(1, 'Administrateur'),
(2, 'Responsable'),
(3, 'Formateur');

-- --------------------------------------------------------

--
-- Table structure for table `TypesCreneau`
--

CREATE TABLE `TypesCreneau` (
  `idTypeCreneau` int(11) NOT NULL,
  `libelleTypeCreneau` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TypesFermeture`
--

CREATE TABLE `TypesFermeture` (
  `idTypeFermeture` int(11) NOT NULL,
  `libelleTypeFermeture` varchar(50) NOT NULL,
  `couleurTypeFermeture` char(7) NOT NULL DEFAULT '#FFFFFF',
  `idAffichageTypeFermeture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Acces`
--
ALTER TABLE `Acces`
  ADD PRIMARY KEY (`idCompte`,`idTypeCompte`),
  ADD KEY `idTypeCompte` (`idTypeCompte`);

--
-- Indexes for table `AffichagesTypesFermeture`
--
ALTER TABLE `AffichagesTypesFermeture`
  ADD PRIMARY KEY (`idAffichageTypeFermeture`);

--
-- Indexes for table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  ADD PRIMARY KEY (`idCalendrierDisponibilite`),
  ADD KEY `idCompte` (`idCompte`);

--
-- Indexes for table `Comptes`
--
ALTER TABLE `Comptes`
  ADD PRIMARY KEY (`idCompte`),
  ADD KEY `idOrganismeFormation` (`idOrganismeFormation`);

--
-- Indexes for table `Contenus`
--
ALTER TABLE `Contenus`
  ADD PRIMARY KEY (`idNomFormation`,`idMatiere`),
  ADD KEY `idMatiere` (`idMatiere`);

--
-- Indexes for table `CreneauDisponibilite`
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
-- Indexes for table `DisposIntervenant`
--
ALTER TABLE `DisposIntervenant`
  ADD PRIMARY KEY (`idCompte`,`idCalendrierDisponibilite`),
  ADD KEY `idCalendrierDisponibilite` (`idCalendrierDisponibilite`);

--
-- Indexes for table `EtatsDisponibilite`
--
ALTER TABLE `EtatsDisponibilite`
  ADD PRIMARY KEY (`idEtatDisponibilite`);

--
-- Indexes for table `Fermeture`
--
ALTER TABLE `Fermeture`
  ADD PRIMARY KEY (`idFermeture`),
  ADD KEY `idTypeFermeture` (`idTypeFermeture`),
  ADD KEY `idNomFermeture` (`idNomFermeture`);

--
-- Indexes for table `Formations`
--
ALTER TABLE `Formations`
  ADD PRIMARY KEY (`idFormation`),
  ADD KEY `idNomFormation` (`idNomFormation`),
  ADD KEY `idSiteOrgaFormation` (`idSiteOrgaFormation`);

--
-- Indexes for table `Matieres`
--
ALTER TABLE `Matieres`
  ADD PRIMARY KEY (`idMatiere`);

--
-- Indexes for table `NomsFermeture`
--
ALTER TABLE `NomsFermeture`
  ADD PRIMARY KEY (`idNomFermeture`);

--
-- Indexes for table `NomsFormation`
--
ALTER TABLE `NomsFormation`
  ADD PRIMARY KEY (`idNomFormation`);

--
-- Indexes for table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  ADD PRIMARY KEY (`idOptionFormation`),
  ADD KEY `idNomFormation` (`idNomFormation`);

--
-- Indexes for table `OrganismesFormation`
--
ALTER TABLE `OrganismesFormation`
  ADD PRIMARY KEY (`idOrganismeFormation`);

--
-- Indexes for table `ProposeOption`
--
ALTER TABLE `ProposeOption`
  ADD PRIMARY KEY (`idOptionFormation`,`idFormation`),
  ADD KEY `idFormation` (`idFormation`);

--
-- Indexes for table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  ADD PRIMARY KEY (`idSiteOrgaFormation`),
  ADD KEY `idOrganismeFormation` (`idOrganismeFormation`);

--
-- Indexes for table `TokenForgetPassword`
--
ALTER TABLE `TokenForgetPassword`
  ADD PRIMARY KEY (`idToken`);

--
-- Indexes for table `TypesCompte`
--
ALTER TABLE `TypesCompte`
  ADD PRIMARY KEY (`idTypeCompte`);

--
-- Indexes for table `TypesCreneau`
--
ALTER TABLE `TypesCreneau`
  ADD PRIMARY KEY (`idTypeCreneau`);

--
-- Indexes for table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  ADD PRIMARY KEY (`idTypeFermeture`),
  ADD KEY `idAffichageTypeFermeture` (`idAffichageTypeFermeture`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AffichagesTypesFermeture`
--
ALTER TABLE `AffichagesTypesFermeture`
  MODIFY `idAffichageTypeFermeture` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  MODIFY `idCalendrierDisponibilite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Comptes`
--
ALTER TABLE `Comptes`
  MODIFY `idCompte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CreneauDisponibilite`
--
ALTER TABLE `CreneauDisponibilite`
  MODIFY `idCreneauDisponibilite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EtatsDisponibilite`
--
ALTER TABLE `EtatsDisponibilite`
  MODIFY `idEtatDisponibilite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Fermeture`
--
ALTER TABLE `Fermeture`
  MODIFY `idFermeture` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Formations`
--
ALTER TABLE `Formations`
  MODIFY `idFormation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Matieres`
--
ALTER TABLE `Matieres`
  MODIFY `idMatiere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NomsFermeture`
--
ALTER TABLE `NomsFermeture`
  MODIFY `idNomFermeture` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NomsFormation`
--
ALTER TABLE `NomsFormation`
  MODIFY `idNomFormation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  MODIFY `idOptionFormation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrganismesFormation`
--
ALTER TABLE `OrganismesFormation`
  MODIFY `idOrganismeFormation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  MODIFY `idSiteOrgaFormation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TokenForgetPassword`
--
ALTER TABLE `TokenForgetPassword`
  MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TypesCompte`
--
ALTER TABLE `TypesCompte`
  MODIFY `idTypeCompte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TypesCreneau`
--
ALTER TABLE `TypesCreneau`
  MODIFY `idTypeCreneau` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  MODIFY `idTypeFermeture` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Acces`
--
ALTER TABLE `Acces`
  ADD CONSTRAINT `Acces_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Acces_ibfk_2` FOREIGN KEY (`idTypeCompte`) REFERENCES `TypesCompte` (`idTypeCompte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CalendriersDisponibilite`
--
ALTER TABLE `CalendriersDisponibilite`
  ADD CONSTRAINT `CalendriersDisponibilite_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Comptes`
--
ALTER TABLE `Comptes`
  ADD CONSTRAINT `Comptes_ibfk_1` FOREIGN KEY (`idOrganismeFormation`) REFERENCES `OrganismesFormation` (`idOrganismeFormation`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Contenus`
--
ALTER TABLE `Contenus`
  ADD CONSTRAINT `idMatiere` FOREIGN KEY (`idMatiere`) REFERENCES `Matieres` (`idMatiere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idNomFormation` FOREIGN KEY (`idNomFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CreneauDisponibilite`
--
ALTER TABLE `CreneauDisponibilite`
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_1` FOREIGN KEY (`idMatiere`) REFERENCES `Matieres` (`idMatiere`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_2` FOREIGN KEY (`idFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_3` FOREIGN KEY (`idCalendrierDisponibilite`) REFERENCES `CalendriersDisponibilite` (`idCalendrierDisponibilite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CreneauDisponibilite_ibfk_5` FOREIGN KEY (`idTypeCreneau`) REFERENCES `TypesCreneau` (`idTypeCreneau`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `DisposIntervenant`
--
ALTER TABLE `DisposIntervenant`
  ADD CONSTRAINT `DisposIntervenant_ibfk_1` FOREIGN KEY (`idCompte`) REFERENCES `Comptes` (`idCompte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `DisposIntervenant_ibfk_2` FOREIGN KEY (`idCalendrierDisponibilite`) REFERENCES `CalendriersDisponibilite` (`idCalendrierDisponibilite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Fermeture`
--
ALTER TABLE `Fermeture`
  ADD CONSTRAINT `Fermeture_ibfk_1` FOREIGN KEY (`idTypeFermeture`) REFERENCES `TypesFermeture` (`idTypeFermeture`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fermeture_ibfk_2` FOREIGN KEY (`idNomFermeture`) REFERENCES `NomsFermeture` (`idNomFermeture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Formations`
--
ALTER TABLE `Formations`
  ADD CONSTRAINT `Formations_ibfk_2` FOREIGN KEY (`idSiteOrgaFormation`) REFERENCES `SitesOrgaFormation` (`idSiteOrgaFormation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Formations_idformatio` FOREIGN KEY (`idNomFormation`) REFERENCES `NomsFormation` (`idNomFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `OptionsFormation`
--
ALTER TABLE `OptionsFormation`
  ADD CONSTRAINT `OptionsFormation_ibfk_1` FOREIGN KEY (`idNomFormation`) REFERENCES `NomsFormation` (`idNomFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProposeOption`
--
ALTER TABLE `ProposeOption`
  ADD CONSTRAINT `ProposeOption_ibfk_1` FOREIGN KEY (`idOptionFormation`) REFERENCES `OptionsFormation` (`idOptionFormation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProposeOption_ibfk_2` FOREIGN KEY (`idFormation`) REFERENCES `Formations` (`idFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `SitesOrgaFormation`
--
ALTER TABLE `SitesOrgaFormation`
  ADD CONSTRAINT `SitesOrgaFormation_ibfk_1` FOREIGN KEY (`idOrganismeFormation`) REFERENCES `OrganismesFormation` (`idOrganismeFormation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TypesFermeture`
--
ALTER TABLE `TypesFermeture`
  ADD CONSTRAINT `TypesFermeture_ibfk_1` FOREIGN KEY (`idAffichageTypeFermeture`) REFERENCES `AffichagesTypesFermeture` (`idAffichageTypeFermeture`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;