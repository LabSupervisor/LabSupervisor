<?php

// Open session
if (isset($_POST["open"])) {
	SessionRepository::state(array_search(lang("SESSION_REOPEN"), $_POST['open']), true);
}
