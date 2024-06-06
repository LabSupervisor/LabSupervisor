<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\entity\User,
	LabSupervisor\app\repository\SessionRepository;
use function LabSupervisor\functions\lang;

if (isset($_POST["modify"])) {
	$userRepo = new UserRepository();
	$email = UserRepository::getEmail($_POST["userId"]);

	$userData = array(
		"email" => $email,
		"name" => $_POST["name"],
		"surname" => $_POST["surname"]
	);

	// Update user
	$user = new User($userData);
	$userRepo->update($user);

	// Update user role
	UserRepository::updateRole($_POST["userId"], $_POST["role_" . $_POST["userId"]]);

	// Update user classroom
	$classroomId = ClassroomRepository::getUserClassroom($_POST["userId"]);
	$studentId = $_POST["userId"];

	ClassroomRepository::removeUser($_POST["userId"], $classroomId);

	if ($_POST["role_" . $_POST["userId"]] == STUDENT) {
		foreach (SessionRepository::getSessions() as $session) {
			if ($session["idclassroom"] == $classroomId) {
				SessionRepository::deleteParticipant($session["id"], $studentId);
				foreach (SessionRepository::getChapter($session["id"]) as $chapter) {
					SessionRepository::deleteStatus($session["id"], $studentId, $chapter["id"]);
				}
			}
		}

		foreach (SessionRepository::getSessions() as $session) {
			if ($session["idclassroom"] == $_POST["classroom_" . $_POST["userId"]]) {
				SessionRepository::addParticipant($studentId, $session["id"]);
				foreach (SessionRepository::getChapter($session["id"]) as $chapter) {
					SessionRepository::addStatus($session["id"], $chapter["id"], $studentId);
				}
			}
		}

		ClassroomRepository::addUser($_POST["userId"], $_POST["classroom_" . $_POST["userId"]]);
	}

	if ($_POST["role_" . $_POST["userId"]] == TEACHER) {
		foreach (ClassroomRepository::getTeacherClassroom($_POST["userId"]) as $value) {
			ClassroomRepository::deleteTeacherClassroom($_POST["userId"], $value["id"]);
		}
		foreach ($_POST["classroom_" . $_POST["userId"]] as $classroomId) {
			if ($classroomId != 0) {
				ClassroomRepository::addTeacherClassroom($_POST["userId"], $classroomId);
			}
		}
	}

	echo '<script> popupDisplay("' . lang("USER_UPDATE_NOTIFICATION") .'"); </script>';
}
