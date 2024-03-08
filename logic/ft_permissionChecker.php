<?php
function permissionChecker($connect, $student, $teacher, $admin) {
	if ($connect == true) {
		// Check if user is connected
		if (isset($_SESSION["login"])) {
			$access = array(
				"student" => $student,
				"teacher" => $teacher,
				"admin" => $admin
			);

			$role = UserRepository::getInfo($_SESSION["login"]);

			// Verify role with page persmission
			if (!(($access["student"] && $role["student"]) || ($access["teacher"] && $role["teacher"]) || ($access["admin"] && $role["admin"]))) {
				// Redirected if not authorised
				header("Location: /denied");
			} else {
				$roleList = array();
				if ($role["student"])
					array_push($roleList, "student");
				if ($role["teacher"])
					array_push($roleList, "teacher");
				if ($role["admin"])
					array_push($roleList, "admin");
				return $roleList;
			}
		} else {
			// Redirected if connected session is imposed
			header("Location: /denied");
		}
	} else {
		if (isset($_SESSION["login"])) {
			// Redirected if connected session is imposed
			header("Location: /denied");
		}
	}
}
