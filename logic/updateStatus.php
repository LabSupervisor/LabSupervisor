<?php
	$db = dbConnect();
	if (isset($_POST["status"])) {
		$idChapter = $_POST['chapter'];
		$status = $_POST['status'];
		$userId = getUserId($_SESSION["login"]);

		// Update state query
		$query = "UPDATE status SET state = :idStatus WHERE idchapter = :idChapter AND iduser = :idUser";

		// Update state
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':idStatus', $status);
		$queryPrep->bindParam(':idChapter', $idChapter);
		$queryPrep->bindParam(':idUser', $userId);
		$queryPrep->execute();
	}
?>
