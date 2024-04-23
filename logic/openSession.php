<?php

use LabSupervisor\app\repository\SessionRepository;
use function LabSupervisor\functions\lang;

// Open session
if (isset($_POST["open"])) {
	SessionRepository::state(array_search(lang("SESSION_ACTION_OPEN"), $_POST['open']), true);
}
