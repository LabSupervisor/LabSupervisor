<?php
	if (isset($_POST["userId"])) {
		$db = dbConnect();

		$query = "UPDATE user SET name = :name, surname = :surname WHERE id = :iduser";

		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $_POST["userId"]);
		$queryPrep->bindParam(':name', $_POST["name"]);
		$queryPrep->bindParam(':surname', $_POST["surname"]);
		$queryPrep->execute();

		header("Refresh:0");
	}
?>
