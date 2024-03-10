<?php

function roleFormat($email) {
	$result = "";
	$userRole = UserRepository::getRole($email);

	$roleList = array();
	foreach ($userRole as $value) {
		array_push($roleList, $value["idrole"]);
	}

	if (in_array(ADMIN, $roleList))
		$result = $result . "Admin";
	if (in_array(STUDENT, $roleList))
		$result = $result . "Etudiant";
	if (in_array(TEACHER, $roleList))
		$result = $result . "Enseignant";

	// Return formatted role
	return $result;
}
