<?php
if (isset($_POST["connect"])) {
	// Get user's roles
	$role = UserRepository::getRole($_SESSION["login"]);
	$roleList = array();
	foreach ($role as $value) {
		array_push($roleList, $value["idrole"]);
	}

	$_SESSION["session"] = array_search(lang("SESSION_STATE_OPEN"), $_POST['connect']);

	// Redirect teacher to /dashboard and student to /panel
	if (in_array(TEACHER, $roleList))
		header("Location: /dashboard");
	else
		header("Location: /panel");
}
