<?php
	if (isset($_POST['saveSession'])) {
		$db = dbConnect();

		// Get data
		$titleSession = $_POST['titleSession'];
		$descriptionSession = $_POST['descriptionSession'];
		$idClasses = $_POST['classes'];

		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];

		try {
			$userId = getUserId($_SESSION["login"]);

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
				Logs::dbSave("Adding session " . $titleSession);
			} else {
				throw new Exception("Create session failed.");
			}
		} catch (Exception $e) {
			Logs::fileSave($e);
		}

		try {
			// Get session ID
			$queryIdSession = "SELECT id FROM session WHERE title = '$titleSession'";
			$queryIdSessionPrep = $db->prepare($queryIdSession);

			if ($queryIdSessionPrep->execute()) {
				$idSession = $queryIdSessionPrep->fetchColumn();
			}

			// Chapter
			$nbChapter = $_POST["nbChapter"];
			for($i = 1; $i<= $nbChapter; $i++){
				$titleChapter = $_POST['titleChapter'.$i];
				$chapterDescription = $_POST['chapterDescription'.$i];

				if ($titleChapter ==""){
					continue;
				}

				$queryBis = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

				$queryPrepBis = $db->prepare($queryBis);

				// Bind parameter
				$queryPrepBis->bindParam(':idsession', $idSession, \PDO::PARAM_STR);
				$queryPrepBis->bindParam(':title', $titleChapter, \PDO::PARAM_STR);
				$queryPrepBis->bindParam(':description', $chapterDescription, \PDO::PARAM_STR);
				$queryPrepBis->bindParam(':idcreator', $userId, \PDO::PARAM_INT);

				// Request execute
				if ($queryPrepBis->execute()) {
					Logs::dbSave("Adding chapter " . $titleChapter);
				} else {
					throw new Exception("Create chapter failed.");
				}
			}

		} catch (Exception $e) {
			Logs::fileSave($e);
		}

	//add classroom student to session

		//get student classroom
		$queryGetStudent = "SELECT iduser FROM userclassroom WHERE idclassroom='$idClasses'" ;
		$queryGetStudentPrep = $db->prepare($queryGetStudent);
		if ($queryGetStudentPrep->execute()) {
			$Class = $queryGetStudentPrep->fetchAll();
			// var_dump($Class) ;
		}

		// var_dump($Class);

		for ($i = 0; $i<count($Class); $i++){
			$idStudent = $Class[$i]['iduser'];
			//participant
			$queryParticipant = "INSERT INTO participant(iduser, idsession) VALUES (:iduser, :idsession) ";
			$queryParticipantPrep = $db->prepare($queryParticipant);
			//bind parameter
			$queryParticipantPrep->bindParam(':iduser', $idStudent, \PDO::PARAM_STR);
			$queryParticipantPrep->bindParam(':idsession', $idSession, \PDO::PARAM_STR);
			$queryParticipantPrep->execute();
		}
	}
?>
