<?php

use
	Dotenv\Dotenv,
	LabSupervisor\app\repository\DatabaseRepository,
	LabSupervisor\app\repository\ActiveDirectoryRepository;

// Load .env file
$dotenv = Dotenv::createImmutable(dirname(__FILE__) . "/../")->load();

// Create constants
define("DEFAULT_LANGUAGE", $_ENV['DEFAULT_LANGUAGE']);
define("DEFAULT_THEME", $_ENV['DEFAULT_THEME']);

define("ADMIN", 1);
define("STUDENT", 2);
define("TEACHER", 3);

// Declare database connection
$db = new DatabaseRepository;
define("DATABASE", $db->getConnection());

if ($_ENV["AUTHENTIFICATION_TYPE"] == "ad") {
	$ad = new ActiveDirectoryRepository;
	define("AD", $ad->getConnection());
}
