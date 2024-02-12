<?php
	function getClass($name) {
		$db = dbConnect();

		// Get user ID query
		$queryClassid = "SELECT id FROM classroom WHERE name = name";

		// Get user ID
		$queryPrepClassId = $db->prepare($queryClassid);
		$queryPrepClassId->bindParam(':name', $name, \PDO::PARAM_STR);
		$queryPrepClassId->execute();
		return($queryPrepClassId->fetchAll(PDO::FETCH_COLUMN)[0]);
	}
?>
