<?php

use LabSupervisor\app\repository\UserRepository;

if (isset($_POST["link"])) {
	// Connect LS-Link with user
	UserRepository::link(UserRepository::getId($_SESSION["login"]), $_POST["sessionId"], $_POST["number"]);
	header("Location: /panel");
}

if (isset($_POST["disconnect"])) {
	// Disconnect LS-Link with user
	UserRepository::unlink(UserRepository::getId($_SESSION["login"]), $_SESSION["session"], $_POST["disconnect"]);
	header("Location: /panel");
}
