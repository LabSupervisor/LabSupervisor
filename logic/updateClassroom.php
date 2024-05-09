<?php

use
	LabSupervisor\app\entity\Classroom,
	LabSupervisor\app\repository\ClassroomRepository;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add student
	if (isset($_POST['addStudent'])) {
		if (!ClassroomRepository::isUserInClassroom($_POST['studentId'], $_POST['classroomId'])) {
			ClassroomRepository::addUser($_POST['studentId'], $_POST['classroomId']);
		}
	// Remove student
	} elseif (isset($_POST['removeStudent'])) {
		ClassroomRepository::removeUser($_POST['removeStudent'], $_POST['classroomId']);
	} elseif (isset($_POST["addClassroom"])) {
		$classroomRepo = new ClassroomRepository;
		$classroomData =  array(
			"name" => $_POST['addClassroom']
		);
		$classroom = new Classroom($classroomData);
		$classroomRepo->createClassroom($classroom);
 	} elseif (isset($_POST['modifyName'])) {
		$classroomRepo = new ClassroomRepository;
		$classroomData =  array(
			"name" => $_POST['modifyName'],
			"id" => $_POST['classroomId']
		);
		$classroom = new Classroom($classroomData);
		$classroomRepo->update($classroom);
	}
}
