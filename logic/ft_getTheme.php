<?php
	function getTheme($email) {
		$userId = getUserId($email);

		$db = dbConnect();

		// Get user ID query
		$queryTheme = "SELECT theme FROM setting WHERE iduser = :iduser";

		// Get user ID
		$queryPrepTheme = $db->prepare($queryTheme);
		$queryPrepTheme->bindParam(':iduser', $userId);
		$queryPrepTheme->execute();
		return($queryPrepTheme->fetchAll(PDO::FETCH_COLUMN)[0]);
	}
?>
