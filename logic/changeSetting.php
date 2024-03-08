<?php
if (isset($_POST['changeSetting'])) {
	// Convert theme value
	if ($_POST["theme"] == "light")
		$theme = 0;
	else
		$theme = 1;

	$userSetting = array(
		"theme" => $theme
	);

	// Update user's settings
	UserRepository::updateSetting($userSetting);

	header("Refresh:0");
}
