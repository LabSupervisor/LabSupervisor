<?php

if (isset($_POST["modify"])) {
	echo "";
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

	$userClass = ClassroomRepository::getUserClassroom($_POST["userId"]);
	ClassroomRepository::removeUser($_POST["userId"], $userClass);
	ClassroomRepository::addUser($_POST["userId"], ClassroomRepository::getId($_POST["classroom_" . $_POST["userId"]]));
}
