<?php

if (isset($_POST["register"])) {
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$userData = array(
		"email" => $_POST['email'],
		"name" => $_POST['name'],
		"surname" => $_POST['surname'],
		"password" => $password
	);

	// Checking if the password is the same from confirm
	if ($_POST['password'] != $_POST['confpass']) {
		echo lang("REGISTER_ERROR_NOTSAME");
	} elseif (UserRepository::getId($_POST['email'])) {
		echo lang("REGISTER_ERROR_EMAILTAKEN");
	} else {
		// Create user
		$userRepo = new UserRepository();
		$user = new User($userData);
		$userRepo->createUser($user);

		// Connect user
		$_SESSION["login"] = $_POST['email'];
		header("Location: /");
	}
}
