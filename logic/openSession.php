<?php

// Open session
if (isset($_POST["open"])) {
	SessionRepository::state(array_search(lang("SESSION_OPEN"), $_POST['open']), true);
}
