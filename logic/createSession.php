<?php
/**
 * This file handles the creation, updating, deletion, and pre-filling of sessions.
 * It uses repositories to interact with the database and entities to represent data.
 * Different actions are triggered based on the received POST data.
 *
 */

use LabSupervisor\app\repository\SessionRepository;
use LabSupervisor\app\entity\Session;
use LabSupervisor\app\repository\ClassroomRepository;
use LabSupervisor\app\repository\UserRepository;

use function LabSupervisor\functions\lang;

if (isset($_POST['saveSession'])) {
	/*
	* ********************************************************
	* Case 1 : Save all infos in order to create a new session
	* ********************************************************
	* */
	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$classroomId = $_POST['classes'];
	$creatorId = $_SESSION['login'];
	$date = $_POST['date'];
	// This is an array containing the iduser of the teachers to be added
	$toBeAddedTeachers = isset($_POST['addedTeachers']) === true ? $_POST['addedTeachers'] : [];

	$sessionData = [
		'title' => $title,
		'description' => $description,
		'idclassroom' => $classroomId,
		'idcreator' => $creatorId,
		'date' => $date,
	];

	// Create session
	$session = new Session($sessionData);
	$sessionRepo->createSession($session);
	$sessionId = SessionRepository::getId($title);

	$classUsers = ClassroomRepository::getUsers($classroomId);

	// Add participants
	foreach ($classUsers as $user) {
		SessionRepository::addParticipant($user['iduser'], $sessionId);
	}

	if (isset($_POST['addChapters'])) {
		$addChapters = $_POST['addChapters'];
		foreach ($addChapters as $addChapter) {
			SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
		}

		$idChaptersNoStatus = SessionRepository::getChapterNoStatus($sessionId);
		foreach ($classUsers as $user) {
			foreach ($idChaptersNoStatus as $value) {
				SessionRepository::addStatus($sessionId, $value['chapterId'], $user['iduser']);
			}
		}
	}

	// Add teacher to his own session
	SessionRepository::addParticipant($_SESSION['login'], $sessionId);

	// Add other teachers
	foreach ($toBeAddedTeachers as $teacherId) {
		SessionRepository::addParticipant($teacherId, $sessionId);
	}

	if (isset($_POST['state'])) {
		SessionRepository::setState($sessionId, 1);
	}

	setcookie('notification', lang('SESSION_CREATE_NOTIFICATION'), 0);

	header('Location: /sessions');
} elseif (isset($_POST['updateSession'])) {
	/*
	* ********************************************************
	* Case 2 : Update an existing session after the user pressed the 'Update' button
	* ********************************************************
	* */
	$sessionRepo = new SessionRepository();

	$title = $_POST['titleSession'];
	$description = $_POST['descriptionSession'];
	$classroomId = $_POST['classes'];
	$creatorId = $_SESSION['login'];
	$date = $_POST['date'];
	$sessionId = $_POST['idSession'];
	// Array containing teachers already linked to the session
	$currentTeachers = SessionRepository::getTeacherParticipants($sessionId);
	// This is an array containing the iduser of the teachers to be added
	$toBeAddedTeachers = isset($_POST['addedTeachers']) === true ? $_POST['addedTeachers'] : [];
	// Array containing the if of the teachers to be removed
	$toBeRemovedTeachers = isset($_POST['removedTeachers']) === true ? $_POST['removedTeachers'] : [];

	$sessionData = [
		'title' => $title,
		'description' => $description,
		'idclassroom' => $classroomId,
		'idcreator' => $creatorId,
		'date' => $date,
		'id' => $sessionId,
	];

	// update session
	$session = new Session($sessionData);
	$sessionRepo->update($session);

	foreach (SessionRepository::getParticipants($sessionId) as $user) {
		UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
	}

	// Add participants
	$classUsers = ClassroomRepository::getUsers($classroomId);

	// Add new teachers
	foreach ($toBeAddedTeachers as $teacherId) {
		// if the teacher is not already in the session
		if (in_array($teacherId, array_column($currentTeachers, 'iduser')) === false) {
			SessionRepository::addParticipant($teacherId, $sessionId);
		}
	}

	// Remove teachers
	// TODO : consistency with addParticipant
	foreach ($toBeRemovedTeachers as $teacherId) {
		SessionRepository::deleteParticipant($sessionId, $teacherId);
	}

	if (isset($_POST['classroomChange'])) {
		// Remove participants
		foreach (SessionRepository::getParticipants($sessionId) as $user) {
			foreach (SessionRepository::getChapter($sessionId) as $value) {
				SessionRepository::deleteStatus($sessionId, $user['iduser'], $value['id']);
			}
			UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
			SessionRepository::deleteParticipant($sessionId, $user['iduser']);
		}

		// Add participants
		$classUsers = ClassroomRepository::getUsers($classroomId);
		foreach ($classUsers as $userId) {
			SessionRepository::addParticipant($userId['iduser'], $sessionId);
		}
		foreach (SessionRepository::getChapter($sessionId) as $chapterId) {
			foreach ($classUsers as $userId) {
				SessionRepository::addStatus($sessionId, $chapterId['id'], $userId['iduser']);
			}
		}

		// Add teacher to his own session
		// TODO : do we have to add previous teachers ?
		SessionRepository::addParticipant($creatorId, $sessionId);
	}

	// Add new chapters
	if (isset($_POST['addChapters'])) {
		$addChapters = $_POST['addChapters'];
		foreach ($addChapters as $addChapter) {
			SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
		}

		$idChaptersNoStatus = SessionRepository::getChapterNoStatus($sessionId);
		foreach ($classUsers as $user) {
			foreach ($idChaptersNoStatus as $value) {
				SessionRepository::addStatus($sessionId, $value['chapterId'], $user['iduser']);
			}
		}
	}

	// Update existing schapters
	if (isset($_POST['updatedChapters'])) {
		$updatedChapters = $_POST['updatedChapters'];
		foreach ($updatedChapters as $updatedChapter) {
			SessionRepository::updateChapter($updatedChapter['title'], $updatedChapter['desc'], $creatorId, $updatedChapter['id']);
		}
	}

	// Remove chapters
	if (isset($_POST['deletedChapters'])) {
		$deletededChapters = $_POST['deletedChapters'];
		$participant = SessionRepository::getParticipants($sessionId);

		foreach ($participant as $user) {
			foreach ($deletededChapters as $value) {
				SessionRepository::deleteStatus($sessionId, $user['iduser'], $value);
			}
		}

		foreach ($deletededChapters as $deletedChapter) {
			SessionRepository::deleteChapter($deletedChapter);
		}
	}

	// Update session state
	if (isset($_POST['state'])) {
		if (SessionRepository::getState($sessionId) == 0) {
			SessionRepository::setState($sessionId, 1);
		}
	} else {
		SessionRepository::setState($sessionId, 0);
	}

	$_POST['sessionId'] = $sessionId;
} elseif (isset($_POST['sessionId'])) {
	/*
	* ********************************************************
	* Case 3 : prefill the session form with session data
	* ********************************************************
	* */
	// ASK : in what cases is this used ?
	$sessionRepo = new SessionRepository();
	$sessionInfo = SessionRepository::getInfo($_POST['sessionId']);
	$sessionData = [
		'title' => $sessionInfo[0]['title'],
		'description' => $sessionInfo[0]['description'],
		'idcreator' => $sessionInfo[0]['idcreator'],
		'date' => $sessionInfo[0]['date'],
		'idSession' => $sessionInfo[0]['id'],
	];
	$session = new Session($sessionData);
} elseif (isset($_POST['deleteSession'])) {
	/*
	* ********************************************************
	* Case 4 : delete an existing session after the user pressed the 'Delete' button
	* ********************************************************
	* */
	$sessionId = $_POST['deleteSession'];
	$participant = SessionRepository::getParticipants($sessionId);
	$chapter = SessionRepository::getChapter($sessionId);

	// for each participant
	foreach ($participant as $user) {
		foreach ($chapter as $value) {
			// delete the status of each chapter
			SessionRepository::deleteStatus($sessionId, $user['iduser'], $value['id']);
		}
		// remove the screenshare
		UserRepository::removeScreenshare(UserRepository::getScreenshare($user['iduser'], $sessionId), $sessionId);
		// ASK : what is this ?
		UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
		// delete the participant from the session
		SessionRepository::deleteParticipant($sessionId, $user['iduser']);
	}

	// delete the chapters
	foreach ($chapter as $value) {
		SessionRepository::deleteChapter($value['id']);
	}

	// delete the session
	SessionRepository::delete($sessionId);

	setcookie('notification', lang('SESSION_CREATE_DELETE_NOTIFICATION'), 0);

	// redirect to the sessions page
	header('Location: /sessions');
}
