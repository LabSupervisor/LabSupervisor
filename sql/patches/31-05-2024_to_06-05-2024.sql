CREATE TABLE `screenshare` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idsession` int NOT NULL,
  `idscreenshare` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `screenshare_user_FK` (`iduser`),
  KEY `screenshare_session_FK` (`idsession`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `screenshare`
  ADD CONSTRAINT `screenshare_session_FK` FOREIGN KEY (`idsession`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `screenshare_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);
