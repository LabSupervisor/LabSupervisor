<?php
	if (isset($_POST["connect"])) {
		$role = getUserRole($_SESSION["login"]);

		$_SESSION["session"] = array_search("Rejoindre", $_POST['connect']);

		if ($role[0]["teacher"])
			header("Location: /dashboard");
		else
			header("Location: /panel");
	}
?>
