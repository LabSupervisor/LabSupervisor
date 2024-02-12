<?php
	function getUsers() {
		$db = dbConnect();

		$query = "SELECT us.id, us.surname, us.name, us.email, us.birthdate, rl.student, rl.teacher, rl.admin, cl.name AS 'classroom' FROM user us INNER JOIN role rl ON us.id = rl.iduser LEFT JOIN userclassroom ucl ON us.id = ucl.iduser LEFT JOIN classroom cl ON cl.id = ucl.idclassroom ORDER BY id";

		$queryPrep = $db->prepare($query);
		if ($queryPrep->execute()) {
			return($queryPrep->fetchAll());
		}
	}
?>
