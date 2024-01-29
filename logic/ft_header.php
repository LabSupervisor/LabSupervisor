<?php
	function mainHeader($title) {
		// Import main functions
		require($_SERVER["DOCUMENT_ROOT"] . "/config/import.php");

		if ($title != "")
			$title = $title . " - LabSupervisor";
		else
			$title = "LabSupervisor";

		$userTheme = getTheme($_SESSION["login"]);

		if ($userTheme == 0)
			$theme = "colorlight";
		else
			$theme = "colordark";

		echo <<<EOT
			<html lang="fr">
			<head>
				<meta charset="UTF-8">
				<title>$title</title>
				<link rel="stylesheet" href="../public/css/$theme.css">
				<link rel="stylesheet" href="../public/css/main.css">
				<link rel="stylesheet" href="../public/css/navbar.css">
				<link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
				<link rel="icon" href="../public/img/logo.ico" />
			</head>
		EOT;

		// Import navbar
		require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_navbar.php");
	}
?>
