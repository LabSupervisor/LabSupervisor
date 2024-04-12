<?php

function lang($key) {
	if (isset($_SESSION["login"]))
		$userLang = UserRepository::getSetting($_SESSION["login"])["lang"];
	else
		$userLang = DEFAULT_LANGUAGE;

	// Get value
	if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/lang/" . $userLang . ".json")) {
		$json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/lang/" . $userLang . ".json");
		$data = json_decode($json);
	} else {
		return "Missing entry";
	}

	if (isset($data->$key)) {
		// If entry exist
		return $data->$key;
	} else {
		// If entry doesn't exists, get default value
		$default = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/lang/" . DEFAULT_LANGUAGE . ".json");
		$data = json_decode($default);
		if (isset($data->$key)) {
			return $data->$key;
		} else {
			// If default value doesn't contain entry
			return "Missing entry";
		}
	}
}
