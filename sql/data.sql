INSERT INTO `user` VALUES (1,'admin@labsupervisor.com','$2a$12$hza1VTPclFDpWRFBvumpROMzc6k0Y.2NGpp7UNHpS0ZtXcFdC7q6C','admin','admin',1,'2024-01-14 00:31:06','2024-01-14 00:31:06'),(2,'jerome@gmail.com','$2a$12$hooN56uVwwZMaZ5jrIjZau80.FzDqCFxLqk9KvhIpDRiI/UUI8qLG','Jerome','Luimeme',1,'2024-01-15 22:22:52','2024-01-14 00:31:06'),(3,'mathilde34@hotmail.com','$2a$12$hooN56uVwwZMaZ5jrIjZau80.FzDqCFxLqk9KvhIpDRiI/UUI8qLG','Mathilde','De Labas',1,'2024-01-15 22:23:55','2024-01-14 00:31:06'),(4,'jean.pro@laposte.net','$2a$12$rfwZj5B7m783UagiV0kFDueuu7Kf14QGLOPf.JQ0Zg5ZRgO64A1oy','Jean','Duthé',1,'2024-01-15 22:25:21','2024-01-14 00:31:06'),(5,'unprof@gmail.com','$2a$12$5qZc.PSHwAd2blAqcxTrQue2ZsjHTjKe1qKJUvQfvu.GAQNA2IZpO','Prof','Lautrelà',1,'2024-01-15 22:26:20','2024-01-14 00:31:06');

INSERT INTO `classroom` VALUES (1,'1SNIR',1,'2024-01-14 00:47:46','2024-01-30 00:31:06'),(2,'SIO',1,'2024-01-14 00:47:46','2024-01-30 00:31:06'),(3,'SEGPA',1,'2024-01-14 00:47:46','2024-01-30 00:31:06');

INSERT INTO `userclassroom` VALUES (1,2,1,'2024-01-14 00:31:27'),(2,3,1,'2024-01-14 00:31:27'),(3,4,3,'2024-01-14 00:31:27');

INSERT INTO `role` VALUES (1,'admin','2024-03-08 10:36:05','2024-03-08 10:36:05'),(2,'student','2024-03-08 10:36:05','2024-03-08 10:36:05'),(3,'teacher','2024-03-08 10:36:05','2024-03-08 10:36:05');

INSERT INTO `userrole` VALUES (1,1,1,'2024-03-08 10:38:12'),(2,2,2,'2024-03-08 10:38:12'),(3,3,2,'2024-03-08 10:38:12'),(4,4,2,'2024-03-08 10:38:12'),(5,5,3,'2024-03-08 10:38:12');

INSERT INTO `session` VALUES (1,'Cours PHP','Du php',5,1,'2024-01-14 00:47:46','2024-01-14 00:47:46','2024-01-30 00:31:06'),(2,'MySQL','BDD forever',5,0,'2024-03-30 00:31:06','2024-01-14 00:47:46','2024-01-30 00:31:06');

INSERT INTO `chapter` VALUES (1,1,'JS pour les nuls','Ouais hein',5,'2024-01-17 18:44:58','2024-01-17 18:44:58'),(2,1,'PHP en plus ?',NULL,5,'2024-01-17 18:45:13','2024-01-17 18:45:13'),(3,2,'MYSQL et puis quoi encore',NULL,5,'2024-01-17 18:45:29','2024-01-17 18:45:29');

INSERT INTO `participant` VALUES (1,2,1,'2024-01-17 18:45:29'),(2,3,1,'2024-01-17 18:45:29');

INSERT INTO `setting` VALUES (1,1,1,'fr_FR','2024-01-19 21:32:23'),(2,2,0,'fr_FR','2024-01-19 21:32:58'),(3,3,0,'fr_FR','2024-01-19 21:33:10'),(4,4,0,'fr_FR','2024-01-19 21:33:10'),(5,5,0,'fr_FR','2024-01-19 21:33:10');

INSERT INTO `status` VALUES (1,2,1,2,1,'2024-01-19 21:32:23'),(2,2,1,1,2,'2024-01-19 21:32:23'),(3,3,1,0,1,'2024-03-09 00:08:07'),(4,3,1,0,2,'2024-03-09 00:08:07'),(5,2,2,2,3,'2024-03-09 00:08:07'),(6,4,2,0,3,'2024-01-19 21:32:23');
