<?php
	function mainHeader($title) {
		// Import main functions
		require($_SERVER["DOCUMENT_ROOT"] . "/config/import.php");

		if ($title != "")
			$title = $title . " - LabSupervisor";
		else
			$title = "LabSupervisor";

		if (isset($_SESSION["login"]))
			if (getTheme($_SESSION["login"]) == 0)
				$theme = "colorlight";
			else
				$theme = "colordark";
		else
			$theme = "colorlight";

		echo <<<EOT
			<html lang="fr">
			<head>
				<meta charset="UTF-8">
				<title>$title</title>
				<link rel="stylesheet" href="../public/css/$theme.css">
				<link rel="stylesheet" href="../public/css/main.css">
				<link rel="stylesheet" href="../public/css/navbar.css">
				<link rel="stylesheet" href="../public/css/import/remixicon.css">
				<link rel="icon" href="../public/img/logo.ico" />
			</head>
		EOT;

		// Import navbar
		require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_navbar.php");
	}
?>
