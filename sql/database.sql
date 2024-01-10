use labweb;

--
-- Table structure for table `avancement`
--

DROP TABLE IF EXISTS `avancement`;
CREATE TABLE `avancement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idetape` int NOT NULL,
  `iduser` int NOT NULL,
  `etat` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_avancement` (`idetape`),
  KEY `fk_avancement_utilisateur` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE `classe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE `etape` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idsession` int NOT NULL,
  `libelle` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idsession` (`idsession`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `lierclasse`
--

DROP TABLE IF EXISTS `lierclasse`;
CREATE TABLE `lierclasse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idclasse` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_delaclasse_user` (`iduser`),
  KEY `FK_classe_idclasse` (`idclasse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `lierrole`
--

DROP TABLE IF EXISTS `lierrole`;
CREATE TABLE `lierrole` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idrole` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_alerole_user` (`iduser`),
  KEY `FK_role_idrole` (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE `participant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idsession` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_participant` (`iduser`),
  KEY `FK_session_participant` (`idsession`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `idproprietaire` int NOT NULL,
  `datecreation` datetime NOT NULL,
  `datefin` datetime NOT NULL,
  `etat` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `motdepasse` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `datecreation` datetime NOT NULL,
  `datenaissance` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

ALTER TABLE `avancement`
  ADD CONSTRAINT `fk_avancement_utilisateur` FOREIGN KEY (`iduser`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_etape_avancement` FOREIGN KEY (`idetape`) REFERENCES `etape` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `etape`
  ADD CONSTRAINT `FK_session_etape` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lierclasse`
  ADD CONSTRAINT `FK_classe_idclasse` FOREIGN KEY (`idclasse`) REFERENCES `classe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_delaclasse_user` FOREIGN KEY (`iduser`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lierrole`
  ADD CONSTRAINT `FK_alerole_user` FOREIGN KEY (`iduser`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_role_idrole` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `participant`
  ADD CONSTRAINT `FK_session_participant` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_participant` FOREIGN KEY (`iduser`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
