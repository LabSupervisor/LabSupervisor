<?php
	function getSessionInfo($sessionId) {
		$db = dbConnect();

		// Get session info query
		$querySession = "SELECT * FROM session WHERE id = :idsession";

		// Get session info
		$queryPrepSession = $db->prepare($querySession);
		$queryPrepSession->bindParam(':idsession', $sessionId);
		$queryPrepSession->execute();

		return $queryPrepSession->fetchAll(PDO::FETCH_ASSOC);
	}
?>
