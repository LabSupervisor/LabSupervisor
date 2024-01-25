<?php
	function getSession() {
		$db = dbConnect();

		// Get user ID query
		$queryUserId = "SELECT id FROM user WHERE email = :email";
		// Get user session query
		$querySession = "SELECT idsession FROM participant WHERE iduser = :iduser";

		// Get user ID
		$queryPrepUserId = $db->prepare($queryUserId);
		$queryPrepUserId->bindParam(':email', $_SESSION["login"], \PDO::PARAM_STR);
		$queryPrepUserId->execute();
		$userId = $queryPrepUserId->fetchAll(PDO::FETCH_COLUMN)[0];

		// Get user session
		$queryPrepSession = $db->prepare($querySession);
		$queryPrepSession->bindParam(':iduser', $userId);
		$queryPrepSession->execute();

		return $queryPrepSession->fetchAll(PDO::FETCH_ASSOC);
	}
?>
