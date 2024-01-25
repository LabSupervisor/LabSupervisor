<?php
	function permissionChecker($student, $teacher, $admin) {
		$db = dbConnect();
		$access = array(
			"student" => $student,
			"teacher" => $teacher,
			"admin" => $admin
		);

		$queryId = "SELECT id FROM user WHERE email = :email";
		$query = "SELECT student, teacher, admin FROM role WHERE iduser = :iduser";

		$queryPrepId = $db->prepare($queryId);
		$login = $_SESSION["login"];
		$queryPrepId->bindParam(':email', $login);
		$queryPrepId->execute();
		$id = $queryPrepId->fetchAll(\PDO::FETCH_COLUMN);

		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $id[0]);
		$queryPrep->execute();
		$role = $queryPrep->fetchAll(\PDO::FETCH_ASSOC);

		if (!(($access["student"] && $role[0]["student"]) || ($access["teacher"] && $role[0]["teacher"]) || ($access["admin"] && $role[0]["admin"]))) {
			header("Location: http://" . $_SERVER["SERVER_NAME"]);
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
	}
?>
