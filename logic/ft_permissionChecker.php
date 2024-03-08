<?php

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
					if (in_array($value, $accessList)) {
						$access = true;
					}
				}

				if (!$access)
					header("Location: /denied");

				return $userRole;

			// Redirected if connected session is imposed and user not connected
			} else {
				header("Location: /denied");
			}
		} else {
			return UserRepository::getRole($_SESSION["login"]);
		}
	// If disconnected is imposed
	} else {
		// Redirected if disconnected session is imposed and user is connected
		if (isset($_SESSION["login"])) {
			header("Location: /denied");
		}
	}
}
