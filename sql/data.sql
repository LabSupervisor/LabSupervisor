INSERT INTO `classroom` VALUES (1,'1SNIR'),(2,'SIO'),(3,'SEGPA');

INSERT INTO `participant` VALUES (1,2,1),(2,3,1);

INSERT INTO `role` VALUES (1,1,0,0,1,'2024-01-14 00:31:27'),(2,2,1,0,0,'2024-01-15 22:26:40'),(3,3,1,0,0,'2024-01-15 22:27:08'),(4,4,1,0,0,'2024-01-15 22:27:08'),(5,5,0,1,0,'2024-01-15 22:27:08');

INSERT INTO `session` VALUES (1,'Cours PHP','Du php',5,'2024-01-14 00:47:46','2024-01-30 00:31:06');

INSERT INTO `status` VALUES (1,1,1,0,0),(2,2,1,0,0),(3,3,1,0,0),(4,4,1,0,0),(5,5,1,0,0);

INSERT INTO `user` VALUES (1,'admin@labsupervisor.com','$2a$12$hza1VTPclFDpWRFBvumpROMzc6k0Y.2NGpp7UNHpS0ZtXcFdC7q6C','admin','admin','1970-01-01','2024-01-14 00:31:06'),(2,'jerome@gmail.com','$2a$12$hooN56uVwwZMaZ5jrIjZau80.FzDqCFxLqk9KvhIpDRiI/UUI8qLG','Jerome','Luimeme','2001-01-03','2024-01-15 22:22:52'),(3,'mathilde34@hotmail.com','$2a$12$hooN56uVwwZMaZ5jrIjZau80.FzDqCFxLqk9KvhIpDRiI/UUI8qLG','Mathilde','De Labas','1988-03-12','2024-01-15 22:23:55'),(4,'jean.pro@laposte.net','$2a$12$rfwZj5B7m783UagiV0kFDueuu7Kf14QGLOPf.JQ0Zg5ZRgO64A1oy','Jean','Duthé','1999-12-31','2024-01-15 22:25:21'),(5,'unprof@gmail.com','$2a$12$5qZc.PSHwAd2blAqcxTrQue2ZsjHTjKe1qKJUvQfvu.GAQNA2IZpO','Prof','Lautrelà','2004-04-03','2024-01-15 22:26:20');

INSERT INTO `userclassroom` VALUES (1,2,1),(2,3,1),(3,4,3);
