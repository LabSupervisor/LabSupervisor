<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$db = dbConnect();

		$newName = $_POST['new_name'];
		$newSurname = $_POST['new_surname'];
		$newPassword = $_POST['new_password'];
		$confPassword = $_POST['conf_password'];
		$userId = getUserId($_SESSION["login"]);

		// Sending to the db a new user if the form is not empty
		if (!empty($newName)) {
			$sqlUpdateName = "UPDATE user SET name = :name WHERE id = :iduser";
			$stmtUpdateName = $db->prepare($sqlUpdateName);
			$stmtUpdateName->bindParam(':name', $newName);
			$stmtUpdateName->bindParam(':iduser', $userId);
			$stmtUpdateName->execute();
		}

		// Sending to the db a new name if the form is not empty
		if (!empty($newSurname)) {
			$sqlUpdateSurname = "UPDATE user SET surname = :surname WHERE id = :iduser";
			$stmtUpdateSurname = $db->prepare($sqlUpdateSurname);
			$stmtUpdateSurname->bindParam(':surname', $newSurname);
			$stmtUpdateSurname->bindParam(':iduser', $userId);
			$stmtUpdateSurname->execute();
		}

		//checking if the password is the same in on the two form
		if ($newPassword != $confPassword) {
			echo "Les mots de passes ne correspondent pas !";
		}

		else {
			// Sending to the db the new password using bcrypt algo if the form is not empty
			if (!empty($newPassword)) {
				$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
				$sqlUpdatePassword = "UPDATE user SET password = :password WHERE id = :iduser";
				$stmtUpdatePassword = $db->prepare($sqlUpdatePassword);
				$stmtUpdatePassword->bindParam(':password', $hashedPassword);
				$stmtUpdatePassword->bindParam(':iduser', $userId);
				$stmtUpdatePassword->execute();

				header("Location: /logic/disconnect.php");
			}
		}
		header("Refresh:0");
	}
?>
