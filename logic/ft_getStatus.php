<?php
	function getStatus($chapter) {
		$db = dbConnect();

		$userId = getUserId($_SESSION["login"]);

		// Get status query
		$sqlstate = "SELECT state FROM status WHERE idchapter = :idChapter AND iduser = :idUser";

		// Get status
		$stmtState = $db->prepare($sqlstate);
		$stmtState->bindParam(':idChapter', $chapter);
		$stmtState->bindParam(':idUser', $userId);
		$stmtState->execute();
		return($stmtState->fetch(PDO::FETCH_COLUMN));
	}
?>
