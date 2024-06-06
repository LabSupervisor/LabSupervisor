CREATE TABLE `teacherclassroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idclassroom` int(11) NOT NULL,
  `updatedate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `teacherclassroom_user_FK` (`iduser`),
  KEY `teacherclassroom_classroom_FK` (`idclassroom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `teacherclassroom`
  ADD CONSTRAINT `teacherclassroom_classroom_FK` FOREIGN KEY (`idclassroom`) REFERENCES `classroom` (`id`),
  ADD CONSTRAINT `teacherclassroom_user_FK` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);
