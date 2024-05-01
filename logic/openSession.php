<?php

use LabSupervisor\app\repository\SessionRepository;

// Open session
if (isset($_POST["open"])) {
	SessionRepository::setState($_SESSION["session"], $_POST['open']);
}
