<?php

function lang($key) {
	if (isset($_SESSION["login"]))
		$userLang = UserRepository::getSetting($_SESSION["login"])["lang"];
	else
		$userLang = "fr_FR";

	// Get value
	$json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/lang/" . $userLang . ".json");
	$data = json_decode($json);

	return $data->$key;
}
