<?php
	function getClassroom() {
		$db = dbConnect();

		// Get classroom query
		$query = "SELECT * FROM classroom";

		// Get classroom
		$queryPrep = $db->query($query);
		return($queryPrep->fetchAll(PDO::FETCH_ASSOC));
	}
?>
