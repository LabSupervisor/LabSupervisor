ALTER TABLE `setting`
  MODIFY COLUMN theme VARCHAR(16) DEFAULT 0 NOT NULL;

UPDATE setting
  SET theme = "redLight";
