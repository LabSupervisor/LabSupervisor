<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Add student
	if (isset($_POST['add_student'])) {
		if (!ClassroomRepository::isUserInClassroom($_POST['student_id'], $_POST['class_id'])) {
			ClassroomRepository::addUser($_POST['student_id'], $_POST['class_id']);
		}
	// Remove student
	} elseif (isset($_POST['remove_student'])) {
		ClassroomRepository::removeUser($_POST['remove_student'], $_POST['class_id']);
	}
}
