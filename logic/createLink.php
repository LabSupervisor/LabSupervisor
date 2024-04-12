<?php

use LabSupervisor\app\repository\UserRepository;

if (isset($_POST["link"])) {
	// Connect LS-Link with user
	UserRepository::link(UserRepository::getId($_SESSION["login"]), $_POST["sessionId"], $_POST["number"]);
	header("Location: /panel");
}
