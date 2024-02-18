<?php
	$db = dbConnect();
	if (isset($_POST["status"])) {
		$idChapter = $_POST['chapter'];
		$status = $_POST['status'];
		$userId = UserRepository::getId($_SESSION["login"]);
		$session = $_SESSION["session"];

		// Update state query
		$query = "UPDATE status SET state = :idStatus WHERE idchapter = :idChapter AND iduser = :idUser AND idsession = :idSession";

		try {
			// Update state
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idStatus', $status);
			$queryPrep->bindParam(':idChapter', $idChapter);
			$queryPrep->bindParam(':idUser', $userId);
			$queryPrep->bindParam(':idSession', $session);

			if ($queryPrep->execute())
				LogRepository::dbSave("Update status to " . $status . " from session " . $session);
			else
				throw new Exception("Status " . $status . " from session " . $session . " update error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}
?>
