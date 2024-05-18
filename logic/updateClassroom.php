<?php

use
	LabSupervisor\app\entity\Classroom,
	LabSupervisor\app\repository\ClassroomRepository,
	LabSupervisor\app\repository\SessionRepository;

// Add student
if (isset($_POST['addStudent'])) {
	$classroomId = $_POST['classroomId'];
	$studentId = $_POST['studentId'];

	if (!ClassroomRepository::isUserInClassroom($studentId, $classroomId)) {
		ClassroomRepository::addUser($studentId, $classroomId);
	}

	foreach (SessionRepository::getSessions() as $session) {
		if ($session["idclassroom"] == $classroomId) {
			SessionRepository::addParticipant($studentId, $session["id"]);
			foreach (SessionRepository::getChapter($session["id"]) as $chapter) {
				SessionRepository::addStatus($session["id"], $chapter["id"], $studentId);
			}
		}
	}
}

// Remove student
if (isset($_POST['removeStudent'])) {
	$classroomId = $_POST['classroomId'];
	$studentId = $_POST['removeStudent'];

	foreach (SessionRepository::getSessions() as $session) {
		if ($session["idclassroom"] == $classroomId) {
			SessionRepository::deleteParticipant($session["id"], $studentId);
			foreach (SessionRepository::getChapter($session["id"]) as $chapter) {
				SessionRepository::deleteStatus($session["id"], $studentId, $chapter["id"]);
			}
		}
	}

	ClassroomRepository::removeUser($studentId, $classroomId);
}

// Add classroom
if (isset($_POST["addClassroom"])) {
	$classroomRepo = new ClassroomRepository;
	$classroomData =  array(
		"name" => $_POST['addClassroom']
	);
	$classroom = new Classroom($classroomData);
	$classroomRepo->createClassroom($classroom);
}

if (isset($_POST["deleteClassroom"])) {
	ClassroomRepository::delete($_POST["deleteClassroom"]);
}

// Modify classroom
if (isset($_POST['modifyName'])) {
	$classroomRepo = new ClassroomRepository;
	$classroomData =  array(
		"name" => $_POST['modifyName'],
		"id" => $_POST['classroomId']
	);
	$classroom = new Classroom($classroomData);
	$classroomRepo->update($classroom);
}
