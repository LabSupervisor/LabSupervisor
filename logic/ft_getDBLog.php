<?php
	function getDBLog() {
		$db = dbConnect();

		// Get session info query
		$query = "SELECT * FROM log";

		// Get session info
		$queryPrep = $db->prepare($query);
		$queryPrep->execute();

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC);
	}
?>
