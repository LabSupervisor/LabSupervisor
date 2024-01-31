<?php
	if (isset($_POST['changeSetting'])) {
		$db = dbConnect();
		$userId = getUserId($_SESSION["login"]);
		$date = date('Y-m-d H:i:s');

		if ($_POST["theme"] == "light")
			$theme = 0;
		else
			$theme = 1;

		// Theme query
		$queryTheme = "UPDATE setting SET theme = :theme, updatedate = :date WHERE iduser = :iduser";
		// Background query
		$queryBackground = "UPDATE setting SET background = :background, updatedate = :date WHERE iduser = :iduser";

		// Theme
		$queryPrepTheme = $db->prepare($queryTheme);
		$queryPrepTheme->bindParam(':iduser', $userId);
		$queryPrepTheme->bindParam(':theme', $theme);
		$queryPrepTheme->bindParam(':date', $date);
		$queryPrepTheme->execute();

		// Background
		$queryPrepBackground = $db->prepare($queryBackground);
		$queryPrepBackground->bindParam(':iduser', $userId);
		$queryPrepBackground->bindParam(':background', $_POST["background"]);
		$queryPrepBackground->bindParam(':date', $date);
		$queryPrepBackground->execute();

		header("Refresh:0");
	}
?>
