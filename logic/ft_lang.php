<?php

function lang($key) {
	if (isset($_SESSION["login"]))
		$userLang = UserRepository::getSetting($_SESSION["login"])["lang"];
	else
		$userLang = DEFAULT_LANGUAGE;

	// Get value
	$json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/lang/" . $userLang . ".json");
	$data = json_decode($json);

	if (isset($data->$key)) {
		return $data->$key;
	} else {
		// Get default value
		$default = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/lang/" . DEFAULT_LANGUAGE . ".json");
		$data = json_decode($default);
		return $data->$key;
	}
}
