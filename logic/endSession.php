<?php

// Close session
if (isset($_POST["close"])) {
	SessionRepository::end($_SESSION["session"]);
	header("Location: /sessions");
}
