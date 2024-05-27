<?php

use LabSupervisor\app\repository\UserRepository;

if (isset($_POST["link"])) {
	// Connect LS-Link with user
	UserRepository::link($_SESSION["login"], $_POST["sessionId"], $_POST["number"]);
}

if (isset($_POST["disconnect"])) {
	// Disconnect LS-Link with user
	UserRepository::unlink($_SESSION["login"], $_SESSION["session"], $_POST["disconnect"]);
}
