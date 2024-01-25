<?php
	// Start session
	session_start();

	// Import database
	require $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";

	// Import logger
	require($_SERVER['DOCUMENT_ROOT'] . "/src/App/Repositories/log.php");

	// Import permission checker
	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_permissionChecker.php");
?>
