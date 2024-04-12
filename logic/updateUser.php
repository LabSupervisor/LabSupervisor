<?php

use LabSupervisor\app\repository\UserRepository;
use LabSupervisor\app\entity\User;

if (isset($_POST['new_name'])) {
	$userData = array(
		"email" => $_SESSION["login"],
		"name" => $_POST['new_name']
	);

	if ($_POST['new_surname'])
		$userData["surname"] = $_POST['new_surname'];

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

	// Update user language
	$theme = UserRepository::getSetting($_SESSION["login"])["theme"];
	$userSetting = array(
		"theme" => $theme,
		"lang" => $_POST["lang"]
	);

	// Update user's settings
	UserRepository::updateSetting(UserRepository::getId($_SESSION["login"]), $userSetting);

	header("Refresh:0");
}
