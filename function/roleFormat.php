<?php

namespace LabSupervisor\functions;
use LabSupervisor\app\repository\UserRepository;

if (!function_exists(__NAMESPACE__ . "/roleFormat")) {
	function roleFormat($userId) {
		$result = "";
		$userRole = UserRepository::getRole($userId);

		$roleList = array();
		foreach ($userRole as $value) {
			array_push($roleList, $value["idrole"]);
		}

		if (in_array(ADMIN, $roleList))
			$result = $result . lang("MAIN_ROLE_ADMIN");
		if (in_array(STUDENT, $roleList))
			$result = $result . lang("MAIN_ROLE_STUDENT");
		if (in_array(TEACHER, $roleList))
			$result = $result . lang("MAIN_ROLE_TEACHER");

		// Return formatted role
		return $result;
	}
}
