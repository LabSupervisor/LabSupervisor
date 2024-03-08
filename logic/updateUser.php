<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userData = array(
		"email" => $_SESSION["login"]
	);

	if ($_POST['new_name'])
		$userData["name"] = $_POST['new_name'];

	if ($_POST['new_surname'])
		$userData["surname"] = $_POST['new_surname'];

	if ($_POST['new_birthDate'])
		$userData["birthDate"] = $_POST['new_birthDate'];

	if ($_POST['new_password']) {
		if ($_POST['new_password'] != $_POST['conf_password']) {
			echo "Les mots de passes ne correspondent pas !";
		} else {
			$userData["password"] = $_POST['new_password'];
		}
	}

	// Update user
	$user = new User($userData);
	$userRepo = new UserRepository();
	$userRepo->update($user);

	header("Refresh:0");
}
