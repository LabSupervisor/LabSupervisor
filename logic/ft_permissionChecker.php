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

				$query = "SELECT student, teacher, admin FROM role WHERE iduser = :iduser";

				$userId = getUserId($_SESSION["login"]);

				$queryPrep = $db->prepare($query);
				$queryPrep->bindParam(':iduser', $userId);
				$queryPrep->execute();
				$role = $queryPrep->fetchAll(\PDO::FETCH_ASSOC);

				if (!(($access["student"] && $role[0]["student"]) || ($access["teacher"] && $role[0]["teacher"]) || ($access["admin"] && $role[0]["admin"]))) {
					header("Location: http://" . $_SERVER["SERVER_NAME"] . "/denied.php");
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
				header("Location: http://" . $_SERVER["SERVER_NAME"] . "/denied.php");
			}
		} else {
			if (isset($_SESSION["login"])) {
				header("Location: http://" . $_SERVER["SERVER_NAME"] . "/denied.php");
			}
		}
	}
?>
