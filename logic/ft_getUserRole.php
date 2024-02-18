<?php
	function getUserRole($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		$query = "SELECT student, teacher, admin FROM role WHERE iduser = :iduser";

		$userId = UserRepository::getId($_SESSION["login"]);

		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $userId);
		$queryPrep->execute();
		return($queryPrep->fetchAll(\PDO::FETCH_ASSOC));
	}
?>
