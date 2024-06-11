<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\SessionRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST['send'])) {
	// Delete user
	UserRepository::delete($_POST['userId']);

	foreach (SessionRepository::getSessions() as $session) {
		if ($session["idclassroom"] == $classroomId) {
			$lslink = UserRepository::getLink($studentId, $session["id"]);
			if (isset($lslink)) {
				UserRepository::removeScreenshare(UserRepository::getScreenshare($studentId, $session["id"]), $session["id"]);
				UserRepository::unlink($studentId, $session["id"], $lslink);
			}
		}
	}

	echo '<script> popupDisplay("' . lang("USER_UPDATE_DELETE_NOTIFICATION") .'"); </script>';
}
