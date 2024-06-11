<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\SessionRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST['send'])) {
	// Delete user
	UserRepository::delete($_POST['send']);

	foreach (SessionRepository::getSessions() as $session) {
		$lslink = UserRepository::getLink($_POST['send'], $session["id"]);
		if (isset($lslink)) {
			UserRepository::removeScreenshare(UserRepository::getScreenshare($_POST['send'], $session["id"]), $session["id"]);
			UserRepository::unlink($_POST['send'], $session["id"], $lslink);
		}
	}

	echo '<script> popupDisplay("' . lang("USER_UPDATE_DELETE_NOTIFICATION") .'"); </script>';
}
