<?php

use LabSupervisor\app\repository\LogRepository;
use function LabSupervisor\functions\mainHeader;

mainHeader("Log Test");

try {
	if (! filter_var("notanemail", FILTER_VALIDATE_EMAIL))
		throw new Exception("Test OK");
} catch (Exception $e) {
	echo "Logging...";
	echo "<br>Log in file...";
	LogRepository::fileSave($e);
	echo "<br>Log in DB...";
	LogRepository::dbSave("Message");
	echo "<br>Log!";
}
