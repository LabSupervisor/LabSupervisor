<?php
if (isset($_POST["login"])) {
	if (UserRepository::getId($_POST['email'])) {
		// Check if password correspond to database
		if (UserRepository::verifyPassword($_POST['email'], $_POST['password'])) {
			// Connect user
			$_SESSION['login'] = $_POST['email'];
			header("Location: /");
		}
	}
	// Default error
	echo lang("LOGIN_ERROR_NOTFOUND");
}
