<?php
if (isset($_POST['changeSetting'])) {
	if ($_POST["theme"] == "light")
		$theme = 0;
	else
		$theme = 1;

	$userSetting = array(
		"theme" => $theme
	);

	UserRepository::updateSetting($userSetting);

	header("Refresh:0");
}
