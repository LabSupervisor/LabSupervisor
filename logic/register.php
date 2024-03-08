<?php

if (isset($_POST["register"])) {
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$userData = array(
		"email" => $_POST['email'],
		"name" => $_POST['name'],
		"surname" => $_POST['surname'],
		"password" => $password,
		"birthDate" => $_POST['birthdate']
	);

	// Checking if the password is the same from confirm
	if ($_POST['password'] != $_POST['confpass']) {
		echo "Password and Confirm Password do not match!";
	} elseif (UserRepository::getId($_POST['email'])) {
		echo "Email already taken. Please choose another.";
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
