<?php
	function getUserRole($email) {
		$db = dbConnect();

		$userId = getUserId($email);

		$query = "SELECT student, teacher, admin FROM role WHERE iduser = :iduser";

		$userId = getUserId($_SESSION["login"]);

		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $userId);
		$queryPrep->execute();
		return($queryPrep->fetchAll(\PDO::FETCH_ASSOC));
	}
?>
