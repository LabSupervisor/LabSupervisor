<?php
if (isset($_POST["theme"])) {
	// Convert theme value
	$lang = UserRepository::getSetting($_SESSION["login"])["lang"];

	if ($_POST["theme"] == "light")
		$theme = 0;
	else
		$theme = 1;

	$userSetting = array(
		"theme" => $theme,
		"lang" => $lang
	);

	// Update user's settings
	UserRepository::updateSetting($userSetting);

	header("Refresh:0");
}
