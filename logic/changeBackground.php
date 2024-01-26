<?php
	if (isset($_POST['changeBackground'])) {
		$db = dbConnect();
		$userId = getUserId($_SESSION["login"]);
		$date = date('Y-m-d H:i:s');

		$query = "UPDATE setting SET background = :background, updatedate = :date WHERE iduser = :iduser";

		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':iduser', $userId);
		$queryPrep->bindParam(':background', $_POST["background"]);
		$queryPrep->bindParam(':date', $date);
		$queryPrep->execute();

		header("Refresh:0");
	}
?>
