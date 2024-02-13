<?php
	function getUserByClassroom($classroomId) {
		$db = dbConnect();

		$query = "SELECT * FROM user WHERE id NOT IN (SELECT iduser FROM userclassroom WHERE idclassroom = :classId)";
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':classId', $classroomId);
		$queryPrep->execute();
		return($queryPrep->fetchAll(PDO::FETCH_ASSOC));
	}
?>
