<?php
	function getUserIdByClassroom($classroomId) {
		$db = dbConnect();

		// Get user id query
		$query = "SELECT iduser FROM userclassroom WHERE idclassroom = :idclassroom";

		// Get user id
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':idclassroom', $classroomId);
		$queryPrep->execute();
		return($queryPrep->fetchAll(PDO::FETCH_ASSOC));
	}
?>
