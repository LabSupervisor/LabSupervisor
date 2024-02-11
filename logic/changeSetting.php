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

		try {
			// Theme
			$queryPrepTheme = $db->prepare($queryTheme);
			$queryPrepTheme->bindParam(':iduser', $userId);
			$queryPrepTheme->bindParam(':theme', $theme);
			$queryPrepTheme->bindParam(':date', $date);

			if ($queryPrepTheme->execute())
				Logs::dbSave("Theme change to " . $theme);
			else
				throw new Exception("Theme " . $theme . " change error");
		} catch (Exception $e) {
			Logs::fileSave($e);
		}

		try {
			// Background
			$queryPrepBackground = $db->prepare($queryBackground);
			$queryPrepBackground->bindParam(':iduser', $userId);
			$queryPrepBackground->bindParam(':background', $_POST["background"]);
			$queryPrepBackground->bindParam(':date', $date);

			if ($queryPrepBackground->execute())
				Logs::dbSave("Background change to " . $_POST["background"]);
			else
				throw new Exception("Background " . $_POST["background"] . " change error");
		} catch (Exception $e) {
			Logs::fileSave($e);
		}

		header("Refresh:0");
	}
?>
