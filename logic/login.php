<?php

use LabSupervisor\app\repository\UserRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST["login"])) {
	if (UserRepository::getId($_POST['email'])) {
		// Check if password correspond to database
		if (UserRepository::verifyPassword($_POST['email'], $_POST['password'])) {
			// Connect user
			$_SESSION['login'] = $_POST['email'];
			header("Location: /");
		}
	}
	// Default error
	echo '<script> popupDisplay("' . lang("LOGIN_ERROR_NOTFOUND") .'"); </script>';
}
