<?php
	if (isset($_POST["userId"])) {
		$db = dbConnect();

		$query = "UPDATE user SET name = :name, surname = :surname WHERE id = :iduser";

		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $_POST["userId"]);
			$queryPrep->bindParam(':name', $_POST["name"]);
			$queryPrep->bindParam(':surname', $_POST["surname"]);

			if ($queryPrep->execute())
				Logs::dbSave("Update user " . $_POST["userId"] . " (" . $_POST["name"] . " " . $_POST["surname"] . ")");
			else
				throw new Exception("User update error");
		} catch (Exception $e) {
			Logs::fileSave($e);
		}

		header("Refresh:0");
	}
?>
