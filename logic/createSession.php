<?php

use
	LabSupervisor\app\repository\SessionRepository,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\entity\Session;

// Case 1 : save all infos in order to create a new session
if (isset($_POST['saveSession'])) {

	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$creatorId = UserRepository::getId($_SESSION["login"]);
	$date = $_POST['date'];

	$sessionData = array(
		"title" => $title,
		"description" => $description,
		"idcreator" => $creatorId,
		"date" => $date
	);

	// Create session
	$session = new Session($sessionData);
	$sessionRepo->createSession($session);
	$sessionId = SessionRepository::getId($title);

	// Add classroom student to session
	$classUsers = ClassroomRepository::getUsers(ClassroomRepository::getName($_POST["classes"]));

	$nbChapter = $_POST["nbChapter"];
	for($i = 1; $i<= $nbChapter; $i++){
		$titleChapter = $_POST['titleChapter'.$i];
		$chapterDescription = $_POST['chapterDescription'.$i];

		if ($titleChapter == ""){
			continue;
		}

		// Add chapters
		SessionRepository::addChapter($_POST['titleChapter'.$i], $_POST['chapterDescription'.$i], $creatorId, $title);

		$chapterId = SessionRepository::getChapterId($titleChapter);

		// Add status
		foreach ($classUsers as $userId) {
			SessionRepository::addStatus($sessionId, $chapterId, $userId["iduser"]);
		}
	}

	// Add participants
	foreach ($classUsers as $userId) {
		SessionRepository::addParticipant($userId["iduser"], $title);
	}
	// Add teacher to his own session
	SessionRepository::addParticipant(UserRepository::getId($_SESSION["login"]), $title);

	header("Location: /sessions");
}

// Case 2 : update an existing session after the user pressed the 'Update' button
else if (isset($_POST['updateSession'])){

	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$creatorId = UserRepository::getId($_SESSION["login"]);
	$date = $_POST['date'];
	$idSession = $_POST['idSession'];

	$sessionData = array(
		"title" => $title,
		"description" => $description,
		"idcreator" => $creatorId,
		"date" => $date,
		"idSession" => $idSession
	);

	// Create session
	$session = new Session($sessionData);
	$sessionRepo->update($session);
	$sessionData = SessionRepository::getInfo($idSession);

	$chapterActiveBd = SessionRepository::getActiveChapter($idSession);
	// var_dump($chapterActiveBd ) ;
	// echo '</br>' . '</br>' ;

	//nombre de chapitre dans la page
	$nbChapter = $_POST["nbChapter"];
	// echo "nombre chapitre sur la page : " . $nbChapter . '</br>';
	// var_dump($_POST);

	if (isset($_POST['updatedChapters'])) {
		$updatedChapters = $_POST['updatedChapters'] ;
		foreach ($updatedChapters as $updatedChapter){
			SessionRepository::updateChapter($updatedChapter['title'], $updatedChapter['desc'], $creatorId, $updatedChapter['id'] , $date);
		}
	}

	if (isset($_POST['deletedChapters'])) {
		$deletededChapters = $_POST['deletedChapters'];
		foreach ($deletededChapters as $deletedChapter) {
			SessionRepository::deleteChapter($deletedChapter);
		}
	}

	//	to do, add status
	header("Location: /sessions");
}

// Case 3 : prefill the session form with session data
else if (isset($_POST['sessionId'])){
	$sessionRepo = new SessionRepository();
	$sessionData = SessionRepository::getInfo($_POST['sessionId']);
	$session = new Session($sessionData[0]);
}

// Case 4 : delete a chapter
// else if (isset($_POST['deleteChapters[]'])){
// 	$chapterIds = $_POST["deleteChapters[]"];
// 	var_dump($chapterIds);
// 	foreach ($chapterIds as $chapterId) {
// 		SessionRepository::deleteChapter($chapterId);
// 	}
// 	header("Location: /sessions");

// }
