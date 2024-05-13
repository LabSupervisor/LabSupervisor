<?php

use
	LabSupervisor\app\repository\SessionRepository;

if (isset($_POST["status"])) {
	// Update status table
	SessionRepository::setStatus($_SESSION["session"], $_POST['chapter'], $_SESSION["login"], $_POST['status']);
}
