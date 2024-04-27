<?php

use LabSupervisor\app\repository\ClassroomRepository;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add student
	if (isset($_POST['addStudent'])) {
		if (!ClassroomRepository::isUserInClassroom($_POST['studentId'], $_POST['classroomId'])) {
			ClassroomRepository::addUser($_POST['studentId'], $_POST['classroomId']);
		}
	// Remove student
	} elseif (isset($_POST['removeStudent'])) {
		ClassroomRepository::removeUser($_POST['removeStudent'], $_POST['classroomId']);
	}
}
