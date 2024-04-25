<?php

use LabSupervisor\app\repository\UserRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST['send'])) {
	// Delete user
	UserRepository::delete(UserRepository::getEmail($_POST['userId']));

	echo '<script> popupDisplay("' . lang("USER_UPDATE_DELETE_NOTIFICATION") .'"); </script>';
}
