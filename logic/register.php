<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\entity\User;
use function LabSupervisor\functions\lang;

if (isset($_POST["register"])) {
	$userData = array(
		"email" => strtolower($_POST['email']),
		"name" => $_POST['name'],
		"surname" => $_POST['surname'],
		"password" => $_POST['password']
	);

	// Checking if the password is the same from confirm
	if ($_POST['password'] != $_POST['confpass']) {
		echo '<script> popupDisplay("' . lang("REGISTER_ERROR_NOTSAME") .'"); </script>';
	} elseif (UserRepository::getId($_POST['email'])) {
		echo '<script> popupDisplay("' . lang("REGISTER_ERROR_EMAILTAKEN") .'"); </script>';
	} else {
		// Create user
		$userRepo = new UserRepository();
		$user = new User($userData);
		$userRepo->createUser($user);

		// Connect user
		$_SESSION["login"] = UserRepository::getId($_POST['email']);
		header("Location: /");
	}
}
