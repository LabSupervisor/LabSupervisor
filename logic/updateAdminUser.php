<?php
if (isset($_POST["modify"])) {
	$userRepo = new UserRepository();

	$email = UserRepository::getEmail($_POST["userId"]);

	$userData = array(
		"email" => $email,
		"name" => $_POST["name"],
		"surname" => $_POST["surname"],
		"birthDate" => $_POST["birthdate"]
	);

	$user = new User($userData);
	$userRepo->update($user);

	header("Refresh:0");
}
