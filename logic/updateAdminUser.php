<?php

if (isset($_POST['selectedClassroom'])) {
	// Récupère la valeur sélectionnée du menu déroulant
	$selectedClassroom = $_POST['selectedClassroom'];

	// Utilise la valeur sélectionnée comme bon te semble
	echo "La classe sélectionnée est : " . $selectedClassroom;
} else {
	echo "Aucune classe sélectionnée.";
}


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

	header("Refresh:0");
}
