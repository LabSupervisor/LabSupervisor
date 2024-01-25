<?php
	function getName($userId) {
		$db = dbConnect();

		// Get user name query
		$query = "SELECT name, surname FROM user WHERE id = :iduser";

		// Get user name
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $userId);
		$queryPrep->execute();
		$userCredential = $queryPrep->fetchAll(PDO::FETCH_ASSOC);

		return $userCredential[0]['name'] . " " . $userCredential[0]['surname'];
	}
?>
