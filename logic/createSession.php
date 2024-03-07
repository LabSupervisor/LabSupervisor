<?php
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

	$session = new Session($sessionData);
	$sessionRepo->createSession($session);
	$sessionId = SessionRepository::getId($title);

	// Add classroom student to session
	$classUsers = ClassroomRepository::getUsers(ClassroomRepository::getName($_POST["classes"]));
	// Chapter
	$nbChapter = $_POST["nbChapter"];
	for($i = 1; $i<= $nbChapter; $i++){
		$titleChapter = $_POST['titleChapter'.$i];
		$chapterDescription = $_POST['chapterDescription'.$i];

		if ($titleChapter == ""){
			continue;
		}

		SessionRepository::addChapter($_POST['titleChapter'.$i], $_POST['chapterDescription'.$i], $creatorId, $title);

		$chapterId = SessionRepository::getChapterId($titleChapter);

		foreach ($classUsers as $userId) {
			SessionRepository::addStatus($sessionId, $chapterId, $userId["iduser"]);
		}
	}

	foreach ($classUsers as $userId) {
		SessionRepository::addParticipant($userId["iduser"], $title);
	}
	SessionRepository::addParticipant(UserRepository::getId($_SESSION["login"]), $title);

	header("Location: /sessions");
}
