<?php

use LabSupervisor\app\repository\SessionRepository;
use LabSupervisor\app\repository\UserRepository;

if (isset($_POST["status"])) {
	// Update status table
	SessionRepository::setStatus($_SESSION["session"], $_POST['chapter'], UserRepository::getId($_SESSION["login"]), $_POST['status']);
}
