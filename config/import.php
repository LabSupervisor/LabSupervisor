<?php
	// Start session
	session_start();

	// Import database
	require $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";

	// Import logger
	require($_SERVER['DOCUMENT_ROOT'] . "/src/App/Repositories/log.php");

?>
