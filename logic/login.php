<?php

use LabSupervisor\app\repository\UserRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST["login"])) {
	$userId = UserRepository::getId(strtolower($_POST["email"]));
	if ($userId) {
		// Check if password correspond to database
		if (UserRepository::verifyPassword($userId, $_POST['password'])) {
			// Connect user
			$_SESSION["login"] = $userId;
			header("Location: /");
		}
	}
	// Default error
	echo '<script> popupDisplay("' . lang("LOGIN_ERROR_NOTFOUND") .'"); </script>';
}
