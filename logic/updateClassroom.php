<?php

// Process form submission to add students
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['add_student'])) {
		if (!ClassroomRepository::isUserInClassroom($_POST['student_id'], $_POST['class_id'])) {
			ClassroomRepository::addUser($_POST['student_id'], $_POST['class_id']);
		}
	} elseif (isset($_POST['remove_student'])) {
		// Remove the student from the class in the database
		ClassroomRepository::removeUser($_POST['remove_student'], $_POST['class_id']);
	}
}
