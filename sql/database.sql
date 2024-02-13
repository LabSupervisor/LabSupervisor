CREATE DATABASE labsupervisor;

use labsupervisor;

DROP TABLE IF EXISTS `chapter`;
CREATE TABLE `chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsession` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `idcreator` int(11) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `chapter_session_FK` (`idsession`),
  KEY `chapter_user_FK` (`idcreator`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `log_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `participant`;
CREATE TABLE `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idsession` int(11) NOT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
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
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `date` datetime NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `session_user_FK` (`idcreator`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `theme` int(11) NOT NULL DEFAULT 0,
  `background` varchar(100) NOT NULL DEFAULT 'default.png',
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `setting_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `idsession` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT 0,
  `idchapter` int(11) DEFAULT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `status_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `userclassroom`;
CREATE TABLE `userclassroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idclassroom` int(11) NOT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usergroup_user_FK` (`iduser`),
  KEY `usergroup_group_FK` (`idclassroom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `chapter_user_FK` FOREIGN KEY (`idcreator`) REFERENCES `user` (`id`);

ALTER TABLE `participant`
  ADD CONSTRAINT `FK_session_participant` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `participant_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `role`
  ADD CONSTRAINT `role_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `session`
  ADD CONSTRAINT `session_user_FK` FOREIGN KEY (`idcreator`) REFERENCES `user` (`id`);

ALTER TABLE `setting`
  ADD CONSTRAINT `setting_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `status`
  ADD CONSTRAINT `status_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `status_chapter_FK` FOREIGN KEY (`idchapter`) REFERENCES `chapter` (`id`),
  ADD CONSTRAINT `status_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`);

ALTER TABLE `log`
  ADD CONSTRAINT `log_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `userclassroom`
  ADD CONSTRAINT `usergroup_group_FK` FOREIGN KEY (`idclassroom`) REFERENCES `classroom` (`id`),
  ADD CONSTRAINT `usergroup_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);
