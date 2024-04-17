<?php

// Show error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Load modules
require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER["DOCUMENT_ROOT"])->load();

use
	LabSupervisor\app\repository\DatabaseRepository,
	LabSupervisor\app\repository\ActiveDirectoryRepository,
	LabSupervisor\app\repository\UserRepository;

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

// Check if user still exist in database
if (isset($_SESSION["login"])) {
	if (UserRepository::isActive($_SESSION["login"]) == 0) {
		// If not, delete session variable
		unset($_SESSION["login"]);
	}
}
