<?php
	if (isset($_POST['saveSession'])) {
		$db = dbConnect();

		// Get data
		$titleSession = $_POST['titleSession'];
		$descriptionSession = $_POST['descriptionSession'];
		$idClasses = $_POST['classes'];

		$date = $_POST['date'];

		try {
			$userId = UserRepository::getId($_SESSION["login"]);

			// Insert session request
			$query = "INSERT INTO session (title, description, idcreator, date) VALUES (:title, :description, :idcreator, :date)";

			$queryPrep = $db->prepare($query);

			// Bind parameters
			$queryPrep->bindParam(':title', $titleSession, \PDO::PARAM_STR);
			$queryPrep->bindParam(':description', $descriptionSession, \PDO::PARAM_STR);
			$queryPrep->bindParam(':idcreator', $userId, \PDO::PARAM_INT);
			$queryPrep->bindParam(':date', $date, \PDO::PARAM_STR);

			// Request execute
			if ($queryPrep->execute()) {
				LogRepository::dbSave("Adding session " . $titleSession);
			} else {
				throw new Exception("Create session failed.");
			}
		} catch (Exception $e) {
			LogRepository::fileSave($e);
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
					LogRepository::dbSave("Adding chapter " . $titleChapter);
				} else {
					throw new Exception("Create chapter failed.");
				}
			}

		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		// Add classroom student to session

		// Get student classroom
		$queryGetStudent = "SELECT iduser FROM userclassroom WHERE idclassroom='$idClasses'" ;
		$queryGetStudentPrep = $db->prepare($queryGetStudent);
		$queryGetStudentPrep->execute();
		$class = $queryGetStudentPrep->fetchAll();

		try {
			for ($i = 0; $i<count($class); $i++){
				$idStudent = $class[$i]['iduser'];
				// Participant
				$queryParticipant = "INSERT INTO participant (iduser, idsession) VALUES (:iduser, :idsession) ";
				$queryParticipantPrep = $db->prepare($queryParticipant);
				// Bind parameter
				$queryParticipantPrep->bindParam(':iduser', $idStudent, \PDO::PARAM_STR);
				$queryParticipantPrep->bindParam(':idsession', $idSession, \PDO::PARAM_STR);
				if ($queryParticipantPrep->execute()) {
					LogRepository::dbSave("Adding participant " . getName($idStudent) . " to " . $idSession);
				} else {
					throw new Exception("Add participant failed.");
				}
			}
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		header("Location: /session");
	}
?>
