<?php
	function getBackground($email) {
		$userId = getUserId($email);

		$db = dbConnect();

		// Get user ID query
		$queryBackground = "SELECT background FROM setting WHERE iduser = :iduser";

		// Get user ID
		$queryPrepBackground = $db->prepare($queryBackground);
		$queryPrepBackground->bindParam(':iduser', $userId);
		$queryPrepBackground->execute();
		return($queryPrepBackground->fetchAll(PDO::FETCH_COLUMN)[0]);
	}
?>
