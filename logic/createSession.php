<?php
	if (isset($_POST['saveSession'])) {
		$db = dbConnect();

		// Get data
		$titleSession = $_POST['titleSession'];
		$descriptionSession = $_POST['descriptionSession'];
		$classes = $_POST['classes'];
		$titleChapter = $_POST['titleChapter'];
		$chapterDescription = $_POST['chapterDescription'];
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];

		try {
			// Get user ID
			$queryIdUser = "SELECT id FROM user WHERE email = :email";
			$queryIdUserPrep = $db->prepare($queryIdUser) ;
			$queryIdUserPrep->bindParam(':email', $_SESSION["login"], \PDO::PARAM_STR);

			if ($queryIdUserPrep->execute()) {
				$userId = $queryIdUserPrep->fetchAll();
			}

			// Insert session request
			$query = "INSERT INTO session (title, description, idcreator, startdate, enddate) VALUES (:title, :description, :idcreator, :startdate, :enddate)";

			$queryPrep = $db->prepare($query);

			// Bind parameters
			$queryPrep->bindParam(':title', $titleSession, \PDO::PARAM_STR);
			$queryPrep->bindParam(':description', $descriptionSession, \PDO::PARAM_STR);
			$queryPrep->bindParam(':idcreator', $userId, \PDO::PARAM_INT);
			$queryPrep->bindParam(':startdate', $startDate, \PDO::PARAM_STR);
			$queryPrep->bindParam(':enddate', $endDate, \PDO::PARAM_STR);

			// Request execute
			if ($queryPrep->execute()) {
				//TODO DB log
			} else {
				throw new Exception("Create session failed.");
			}
		} catch (Exception $e) {
			$log = new Logs($e);
			$log->fileSave();
		}

		try {
			// Get session ID
			$queryIdSession = "SELECT id FROM session WHERE title = '$titleSession'";
			$queryIdSessionPrep = $db->prepare($queryIdSession);

			if ($queryIdSessionPrep->execute()) {
				$idSession = $queryIdSessionPrep->fetchColumn();
			}

			// Chapter
			$queryBis = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

			$queryPrepBis = $db->prepare($queryBis);

			// Bind parameter
			$queryPrepBis->bindParam(':idsession', $idSession, \PDO::PARAM_STR);
			$queryPrepBis->bindParam(':title', $titleChapter, \PDO::PARAM_STR);
			$queryPrepBis->bindParam(':description', $chapterDescription, \PDO::PARAM_STR);
			$queryPrepBis->bindParam(':idcreator', $userId, \PDO::PARAM_INT);

			// Request execute
			if ($queryPrepBis->execute()) {
				//TODO DB log
			} else {
				throw new Exception("Create chapter failed.");
			}
		} catch (Exception $e) {
			$log = new Logs($e);
			$log->fileSave();
		}
	}
?>
