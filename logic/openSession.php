<?php

use LabSupervisor\app\repository\SessionRepository;
use function LabSupervisor\functions\lang;

// Open session
if (isset($_POST["open"])) {
	SessionRepository::setState($_SESSION["session"], $_POST['open']);
}
