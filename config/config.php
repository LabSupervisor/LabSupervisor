<?php
// Show error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Load modules
require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

// Import database
require $_SERVER["DOCUMENT_ROOT"] . "/config/db.php";

// Load class
function loadClass($class)
{
	$entityDirectory = $_SERVER["DOCUMENT_ROOT"] . "/src/app/entity/";
	$repositoryDirectory = $_SERVER["DOCUMENT_ROOT"] . "/src/app/repository/";

	// Import entity
	if (file_exists($entityDirectory . $class . ".php"))
		require($entityDirectory . $class . ".php");

	// Import repository
	if (file_exists($repositoryDirectory . $class . ".php"))
		require($repositoryDirectory . $class . ".php");
}
spl_autoload_register('loadClass');

// Check if user still exist in database
if (isset($_SESSION["login"])) {
	if (UserRepository::isActive($_SESSION["login"]) == 0) {
		// If not, delete session variable
		unset($_SESSION["login"]);
	}
}

// Variables
define("ADMIN", 1);
define("STUDENT", 2);
define("TEACHER", 3);

// Import permission checker
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_permissionChecker.php");

// Import lang
require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_lang.php');
