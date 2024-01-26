<?php
	// Start session
	session_start();

	// Import database
	require $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";

	// Import logger
	require($_SERVER['DOCUMENT_ROOT'] . "/src/App/Repositories/log.php");

	// Import permission checker
	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_permissionChecker.php");

	// Import user id
	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_getUserId.php");

	// Import user name
	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_getName.php");

	// Import background
	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_getBackground.php");
?>
