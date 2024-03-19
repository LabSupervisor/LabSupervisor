<?php

// Close session
if (isset($_POST["close"])) {
	SessionRepository::state($_SESSION["session"], 0);
}
