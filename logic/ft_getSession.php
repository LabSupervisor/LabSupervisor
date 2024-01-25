<?php
	function getSession() {
		$db = dbConnect();

		// Get user session query
		$querySession = "SELECT idsession FROM participant WHERE iduser = :iduser";

		$userId = getUserId($_SESSION["login"]);

		// Get user session
		$queryPrepSession = $db->prepare($querySession);
		$queryPrepSession->bindParam(':iduser', $userId);
		$queryPrepSession->execute();

		return $queryPrepSession->fetchAll(PDO::FETCH_ASSOC);
	}
?>
