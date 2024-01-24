<?php
	$db = dbConnect();

	// Check if the form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Get form database
		$email = $_POST['email'];
		// Hashing password from the form with BCRYPT algorythm
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$birthdate = $_POST['birthdate'];

	// Check if the username is already taken
		$checkemailQuery = "SELECT * FROM user WHERE email=:email";
		$checkemailStmt = $db->prepare($checkemailQuery);
		$checkemailStmt->bindparam("email", $email);
		$checkemailStmt->execute();
		$checkemailResult = $checkemailStmt->fetch(PDO::FETCH_ASSOC);

		// Validate input
		if (empty($email) || empty($password) || empty($name) || empty($surname) || empty($birthdate)) {
			echo "All fields are required.";
		} elseif ($checkemailResult) {
			echo "Email already taken. Please choose another.";
		} else {
			// Registration logic
			// Insert form info into db
			$sql = "INSERT INTO user (email, password, name, surname, birthdate) VALUES (:email, :password, :name, :surname, :birthdate)";
			$sql = $db->prepare($sql);
			// Insert Param into to var in the DB
			$sql->bindParam(":email", $email);
			$sql->bindParam(":password", $password);
			$sql->bindParam(":name", $name);
			$sql->bindParam(":surname", $surname);
			$sql->bindParam(":birthdate", $birthdate);

			// Display success or failure message
			if ($sql->execute()) {
				echo "Registration successful for email: $email";
				echo "<br>";
				echo "You are now log as $email.";
				$_SESSION['email'] = $email;
			}
		}
	}
?>
