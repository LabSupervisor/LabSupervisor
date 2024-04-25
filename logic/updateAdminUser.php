<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\entity\User;
use function LabSupervisor\functions\lang;

if (isset($_POST["modify"])) {
	$userRepo = new UserRepository();
	$email = UserRepository::getEmail($_POST["userId"]);

	$userData = array(
		"email" => $email,
		"name" => $_POST["name"],
		"surname" => $_POST["surname"]
	);

	// Update user
	$user = new User($userData);
	$userRepo->update($user);

	// Update user role
	UserRepository::updateRole($_POST["userId"], $_POST["role_" . $_POST["userId"]]);

	// Update user classroom
	$userClass = ClassroomRepository::getUserClassroom($_POST["userId"]);
	ClassroomRepository::removeUser($_POST["userId"], $userClass);
	if ($_POST["role_" . $_POST["userId"]] == STUDENT)
		ClassroomRepository::addUser($_POST["userId"], $_POST["classroom_" . $_POST["userId"]]);

	echo '<script> popupDisplay("' . lang("USER_UPDATE_NOTIFICATION") .'"); </script>';
}
