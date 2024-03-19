<?php

// Close session
if (isset($_POST["close"])) {
	SessionRepository::state($_SESSION["session"], 0);
}

if (isset($_POST["pause"])) {
	if ($_POST["pause"] == "pause") {
		SessionRepository::setState($_SESSION["session"], 1);
	} else {
		SessionRepository::setState($_SESSION["session"], 0);
	}
}
