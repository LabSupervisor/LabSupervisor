<?php
	$db = dbConnect();
	// Process form submission to add students
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['add_student'])) {
			$classId = $_POST['class_id'];
			$studentId = $_POST['student_id'];
			// Add the student to the class in the database if not already added
			$sqlCheckStudent = "SELECT COUNT(*) AS count FROM userclassroom WHERE idclassroom = :classId AND iduser = :studentId";
			$stmtCheckStudent = $db->prepare($sqlCheckStudent);
			$stmtCheckStudent->bindParam(':classId', $classId);
			$stmtCheckStudent->bindParam(':studentId', $studentId);
			$stmtCheckStudent->execute();
			$count = $stmtCheckStudent->fetchColumn();

			if ($count == 0) {
				$sqlAddStudent = "INSERT INTO userclassroom (idclassroom, iduser) VALUES (:classId, :studentId)";
				$stmtAddStudent = $db->prepare($sqlAddStudent);
				$stmtAddStudent->bindParam(':classId', $classId);
				$stmtAddStudent->bindParam(':studentId', $studentId);
				$stmtAddStudent->execute();
			}
		} elseif (isset($_POST['remove_student'])) {
			$classId = $_POST['class_id'];
			$studentId = $_POST['remove_student'];
			// Remove the student from the class in the database
			$sqlRemoveStudent = "DELETE FROM userclassroom WHERE idclassroom = :classId AND iduser = :studentId";
			$stmtRemoveStudent = $db->prepare($sqlRemoveStudent);
			$stmtRemoveStudent->bindParam(':classId', $classId);
			$stmtRemoveStudent->bindParam(':studentId', $studentId);
			$stmtRemoveStudent->execute();
		}
	}
?>
