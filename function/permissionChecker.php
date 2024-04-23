<?php

namespace LabSupervisor\functions;
use LabSupervisor\app\repository\UserRepository;

if (!function_exists(__NAMESPACE__ . "/permissionChecker")) {
	function permissionChecker($connect, $accessList) {
		// If connected is imposed
		if ($connect == true) {
			// If accessList is specified
			if ($accessList != "") {
				// Check if user is connected
				if (isset($_SESSION["login"])) {

					$userRole = UserRepository::getRole($_SESSION["login"]);

					$access = false;
					foreach ($userRole as $value) {
						if (in_array($value["idrole"], $accessList)) {
							$access = true;
						}
					}

					if (!$access)
						header("Location: /denied");

				// Redirected if connected session is imposed and user not connected
				} else {
					header("Location: /denied");
				}
			}
			$userRole = UserRepository::getRole($_SESSION["login"]);

			$roleList = array();
			foreach ($userRole as $value) {
				array_push($roleList, $value["idrole"]);
			}
			return $roleList;

		// If disconnected is imposed
		} else {
			// Redirected if disconnected session is imposed and user is connected
			if (isset($_SESSION["login"])) {
				header("Location: /denied");
			}
		}
	}
}
