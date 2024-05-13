<?php

use LabSupervisor\app\repository\SessionRepository;

// Close session
if (isset($_POST["close"])) {
	SessionRepository::setState($_SESSION["session"], 0);
}

if (isset($_POST["pause"])) {
	if ($_POST["pause"] == "play") {
		SessionRepository::setState($_SESSION["session"], 2);
	} else {
		SessionRepository::setState($_SESSION["session"], 1);
	}
}
