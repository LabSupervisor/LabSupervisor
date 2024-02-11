<?php
	function permissionChecker($connect, $student, $teacher, $admin) {
		if ($connect == true) {
			if (isset($_SESSION["login"])) {
				$db = dbConnect();
				$access = array(
					"student" => $student,
					"teacher" => $teacher,
					"admin" => $admin
				);

				$role = getUserRole($_SESSION["login"]);

				if (!(($access["student"] && $role[0]["student"]) || ($access["teacher"] && $role[0]["teacher"]) || ($access["admin"] && $role[0]["admin"]))) {
					header("Location: /denied");
				} else {
					$roleList = array();
					if ($role[0]["student"])
						array_push($roleList, "student");
					if ($role[0]["teacher"])
						array_push($roleList, "teacher");
					if ($role[0]["admin"])
						array_push($roleList, "admin");
					return $roleList;
				}
			} else {
				header("Location: /denied");
			}
		} else {
			if (isset($_SESSION["login"])) {
				header("Location: /denied");
			}
		}
	}
?>
