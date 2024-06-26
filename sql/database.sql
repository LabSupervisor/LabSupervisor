CREATE DATABASE labsupervisor;

use labsupervisor;

DROP TABLE IF EXISTS `chapter`;
CREATE TABLE `chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsession` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `idcreator` int(11) NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `chapter_session_FK` (`idsession`),
  KEY `chapter_user_FK` (`idcreator`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_session_participant` (`idsession`),
  KEY `participant_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `idclassroom` int(11) NOT NULL,
  `idcreator` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `session_user_FK` (`idcreator`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `theme` varchar(16) NOT NULL DEFAULT 'redLight',
  `lang` varchar(50) NOT NULL DEFAULT 'fr_FR',
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `creationdate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idrole` int NOT NULL DEFAULT '2',
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userrole_user_FK` (`iduser`),
  KEY `userrole_role_FK` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `userclassroom`;
CREATE TABLE `userclassroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idclassroom` int(11) NOT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usergroup_user_FK` (`iduser`),
  KEY `usergroup_group_FK` (`idclassroom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `teacherclassroom`;
CREATE TABLE `teacherclassroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idclassroom` int(11) NOT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `teacherclassroom_user_FK` (`iduser`),
  KEY `teacherclassroom_classroom_FK` (`idclassroom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idsession` int NOT NULL,
  `idlink` int NOT NULL,
  `connectdate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `link_user_FK` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `screenshare`;
CREATE TABLE `screenshare` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idsession` int NOT NULL,
  `idscreenshare` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `screenshare_user_FK` (`iduser`),
  KEY `screenshare_session_FK` (`idsession`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `chapter_user_FK` FOREIGN KEY (`idcreator`) REFERENCES `user` (`id`);

ALTER TABLE `participant`
  ADD CONSTRAINT `FK_session_participant` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `participant_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_role_FK` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `userrole_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `session`
  ADD CONSTRAINT `session_user_FK` FOREIGN KEY (`idcreator`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `session_classroom_FK` FOREIGN KEY (`idclassroom`) REFERENCES `classroom` (`id`);

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

ALTER TABLE `teacherclassroom`
  ADD CONSTRAINT `teacherclassroom_classroom_FK` FOREIGN KEY (`idclassroom`) REFERENCES `classroom` (`id`),
  ADD CONSTRAINT `teacherclassroom_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);

ALTER TABLE `link`
  ADD CONSTRAINT `link_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `link_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`);

ALTER TABLE `screenshare`
  ADD CONSTRAINT `screenshare_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `screenshare_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);
