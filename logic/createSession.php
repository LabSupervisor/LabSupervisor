<?php

use
	LabSupervisor\app\repository\SessionRepository,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\entity\Session;

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
