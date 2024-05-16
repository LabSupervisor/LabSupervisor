<?php

use
	LabSupervisor\app\repository\SessionRepository,
	LabSupervisor\app\entity\Session,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\repository\UserRepository;
use function LabSupervisor\functions\lang;

// Case 1 : save all infos in order to create a new session
if (isset($_POST['saveSession'])) {

	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$classroomId = $_POST['classes'];
	$creatorId = $_SESSION["login"];
	$date = $_POST['date'];

	$sessionData = array(
		"title" => $title,
		"description" => $description,
		"idclassroom" => $classroomId,
		"idcreator" => $creatorId,
		"date" => $date
	);

	// Create session
	$session = new Session($sessionData);
	$sessionRepo->createSession($session);
	$sessionId = SessionRepository::getId($title);

	$classUsers = ClassroomRepository::getUsers($classroomId);

	// Add participants
	foreach ($classUsers as $userId) {
		SessionRepository::addParticipant($userId["iduser"], $title);
	}

	if (isset($_POST['addChapters'])) {
		$addChapters = $_POST['addChapters'];
		foreach ($addChapters as $addChapter){
			SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
			foreach ($classUsers as $userId) {
				$chapterId = SessionRepository::getChapterId($addChapter['title']);
				SessionRepository::addStatus($sessionId, $chapterId, $userId["iduser"]);
			}
		}
	}

	// Add teacher to his own session
	SessionRepository::addParticipant($_SESSION["login"], $title);

	if (isset($_POST["state"])) {
		SessionRepository::setState($sessionId, 1);
	}

	header("Location: /sessions");
}

// Case 2 : update an existing session after the user pressed the 'Update' button
else if (isset($_POST['updateSession'])) {
	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$classroomId = $_POST["classes"];
	$creatorId = $_SESSION["login"];
	$date = $_POST['date'];
	$sessionId = $_POST['idSession'];

	$sessionData = array(
		"title" => $title,
		"description" => $description,
		"idclassroom" => $classroomId,
		"idcreator" => $creatorId,
		"date" => $date,
		"id" => $sessionId
	);

	// Create session
	$session = new Session($sessionData);
	$sessionRepo->update($session);

	// Remove participants
	foreach (SessionRepository::getParticipants($sessionId) as $user) {
		foreach (SessionRepository::getChapter($sessionId) as $value) {
			SessionRepository::deleteStatus($sessionId, $user["iduser"], $value["id"]);
		}
		UserRepository::unlink($user["iduser"], $sessionId, UserRepository::getLink($user["iduser"], $sessionId));
		SessionRepository::deleteParticipant($sessionId, $user["iduser"]);
	}

	// Add participants
	$classUsers = ClassroomRepository::getUsers($classroomId);
	foreach ($classUsers as $userId) {
		SessionRepository::addParticipant($userId["iduser"], $title);
	}

	// Add teacher to his own session
	SessionRepository::addParticipant($creatorId, $title);

	if (isset($_POST['addChapters'])) {
		$addChapters = $_POST['addChapters'];
		foreach ($addChapters as $addChapter){
			SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
			foreach ($classUsers as $userId) {
				$chapterId = SessionRepository::getChapterId($addChapter['title']);
				SessionRepository::addStatus($sessionId, $chapterId, $userId["iduser"]);
			}
		}
	}

	if (isset($_POST['updatedChapters'])) {
		$updatedChapters = $_POST['updatedChapters'];
		foreach ($updatedChapters as $updatedChapter){
			SessionRepository::updateChapter($updatedChapter['title'], $updatedChapter['desc'], $creatorId, $updatedChapter['id']);
		}
	}

	if (isset($_POST['deletedChapters'])) {
		$deletededChapters = $_POST['deletedChapters'];
		$participant = SessionRepository::getParticipants($sessionId);

		foreach ($participant as $user) {
			foreach ($deletededChapters as $value) {
				SessionRepository::deleteStatus($sessionId, $user["iduser"], $value);
			}
		}

		foreach ($deletededChapters as $deletedChapter) {
			SessionRepository::deleteChapter($deletedChapter);
		}
	}
	$_POST['sessionId'] = $sessionId;
	echo '<script> popupDisplay("' . lang('SESSION_CREATE_UPDATE_NOTIFICATION') .'"); </script>';
}

// Case 3 : prefill the session form with session data
else if (isset($_POST['sessionId'])) {
	$sessionRepo = new SessionRepository();
	$sessionInfo = SessionRepository::getInfo($_POST['sessionId']);
	$sessionData = array(
		"title" => $sessionInfo[0]['title'],
		"description" => $sessionInfo[0]['description'] ,
		"idcreator" => $sessionInfo[0]['idcreator'],
		"date" => $sessionInfo[0]['date'],
		"idSession" => $sessionInfo[0]['id']
	);
	$session = new Session($sessionData);
}

// Case 4 : delete an existing session after the user pressed the 'Delete' button
else if (isset($_POST['deleteSession'])) {
	$sessionId = $_POST['deleteSession'];
	$participant = SessionRepository::getParticipants($sessionId);
	$chapter = SessionRepository::getChapter($sessionId);

	foreach ($participant as $user) {
		foreach ($chapter as $value) {
			SessionRepository::deleteStatus($sessionId, $user["iduser"], $value["id"]);
		}
		UserRepository::unlink($user["iduser"], $sessionId, UserRepository::getLink($user["iduser"], $sessionId));
		SessionRepository::deleteParticipant($sessionId, $user["iduser"]);
	}

	foreach ($chapter as $value) {
		SessionRepository::deleteChapter($value["id"]);
	}

	SessionRepository::delete($sessionId);

	header("Location: /sessions");
}
