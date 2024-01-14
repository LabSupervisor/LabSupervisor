use labsupervisor;

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `participant`;
CREATE TABLE `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idsession` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_session_participant` (`idsession`),
  KEY `participant_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `student` tinyint(1) NOT NULL DEFAULT 1,
  `teacher` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `idcreator` int(11) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `enddate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_user_FK` (`idcreator`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 1,
  `workinprogress` tinyint(1) NOT NULL DEFAULT 0,
  `help` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `status_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `userclassroom`;
CREATE TABLE `userclassroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idclassroom` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usergroup_user_FK` (`iduser`),
  KEY `usergroup_group_FK` (`idclassroom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `participant`
  ADD CONSTRAINT `FK_session_participant` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`)

ALTER TABLE `role`
  ADD CONSTRAINT `role_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`)

ALTER TABLE `session`
  ADD CONSTRAINT `session_user_FK` FOREIGN KEY (`idcreator`) REFERENCES `user` (`id`)

ALTER TABLE `status`
  ADD CONSTRAINT `status_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`)

ALTER TABLE `userclassroom`
  ADD CONSTRAINT `usergroup_group_FK` FOREIGN KEY (`idclassroom`) REFERENCES `classroom` (`id`),
  ADD CONSTRAINT `usergroup_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`)
