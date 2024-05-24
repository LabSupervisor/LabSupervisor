ALTER TABLE `setting`
  MODIFY COLUMN theme VARCHAR(16) DEFAULT 0 NOT NULL;

UPDATE setting
  SET theme = "redLight";

ALTER TABLE `setting`
  MODIFY COLUMN theme varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'redLight' NOT NULL;
