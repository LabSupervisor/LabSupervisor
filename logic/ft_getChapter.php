<?php
	function getChapter($sessionId) {
		$db = dbConnect();

		// Get chapters query
		$query = "SELECT id, title FROM chapter WHERE idsession = :idsession";

		// Get chapters
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':idsession', $sessionId);
		$queryPrep->execute();
		return($queryPrep->fetchAll(PDO::FETCH_ASSOC));
	}
?>
