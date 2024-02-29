<?php
if (isset($_POST["connect"])) {
	$role = UserRepository::getInfo($_SESSION["login"]);

	$_SESSION["session"] = array_search("Rejoindre", $_POST['connect']);

	if ($role["teacher"])
		header("Location: /dashboard");
	else
		header("Location: /panel");
}
