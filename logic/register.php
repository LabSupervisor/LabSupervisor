<?php
	$db = dbConnect();

	// Check if the form is submitted
	if (isset($_POST["register"])) {
		// Get form database
		$email = $_POST['email'];
		// Hashing password from the form with BCRYPT algorythm
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$birthdate = $_POST['birthdate'];
		$confpass = $_POST['confpass'];

		//checking if the password is the same in on the two form
		if ($_POST['password'] != $confpass) {
			echo "Password and Confirm Password do not match!";
		} elseif (getUserId($email)) {
			echo "Email already taken. Please choose another.";
		} else {
			// Registration logic
			// Insert form info into db
			$sql = "INSERT INTO user (email, password, name, surname, birthdate) VALUES (:email, :password, :name, :surname, :birthdate)";
			$sql = $db->prepare($sql);
			// Insert Param into var in the DB
			$sql->bindParam(":email", $email);
			$sql->bindParam(":password", $password);
			$sql->bindParam(":name", $name);
			$sql->bindParam(":surname", $surname);
			$sql->bindParam(":birthdate", $birthdate);
			$sql->execute();

			// Add user into role table
			$userId = getUserId($email);
			$queryRole = "INSERT INTO role (iduser) VALUES (:iduser)";
			$queryPrepRole = $db->prepare($queryRole);
			$queryPrepRole->bindParam(":iduser", $userId);
			$queryPrepRole->execute();

			// Add user into setting table
			$userId = getUserId($email);
			$querySetting = "INSERT INTO setting (iduser) VALUES (:iduser)";
			$queryPrepSetting = $db->prepare($querySetting);
			$queryPrepSetting->bindParam(":iduser", $userId);
			$queryPrepSetting->execute();

			// Display success or failure message
			$_SESSION["login"] = $email;
			header("Location: /");
		}
	}
?>
