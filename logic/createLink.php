<?php

if (isset($_POST["link"])) {
	// Connect LS-Link with user
	UserRepository::link(UserRepository::getId($_SESSION["login"]), $_POST["number"]);
	header("Location: /panel");
}
