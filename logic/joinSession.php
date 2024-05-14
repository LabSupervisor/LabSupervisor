<?php

use LabSupervisor\app\repository\UserRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST["connect"])) {
	$_SESSION["session"] = array_search(lang("SESSION_STATE_OPEN"), $_POST['connect']);

	// Redirect teacher to /dashboard and student to /panel
	if (in_array(TEACHER, UserRepository::getRole($_SESSION["login"])))
		header("Location: /dashboard");
	else
		header("Location: /panel");
}
