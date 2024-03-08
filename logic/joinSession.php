<?php
if (isset($_POST["connect"])) {
	$role = UserRepository::getRole($_SESSION["login"]);

	$_SESSION["session"] = array_search("Rejoindre", $_POST['connect']);

	// Redirect teacher to /dashboard and student to /panel
	if (in_array(teacher, $role))
		header("Location: /dashboard");
	else
		header("Location: /panel");
}
