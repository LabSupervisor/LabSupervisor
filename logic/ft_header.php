<?php
	function mainHeader($title) {
		// Import main functions
		require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

		// Page title
		if ($title != "")
			$title = $title . " - " . lang("MAIN_TITLE");
		else
			$title = lang("MAIN_TITLE");

		// Select user color theme
		if (isset($_SESSION["login"]))
			if (UserRepository::getSetting($_SESSION["login"])["theme"] == 0)
				$theme = "colorlight";
			else
				$theme = "colordark";
		else
			$theme = "colorlight";

		// Setup stylesheet path
		$theme = "/public/css/$theme.css";
		$main = "/public/css/main.css";
		$navbar = "/public/css/navbar.css";
		$remixicon = "/public/css/import/remixicon.css";

		// Create header
		echo <<<EOT
			<!DOCTYPE html>
			<html lang="fr">
			<head>
				<meta charset="UTF-8">
				<title>$title</title>
				<link rel="stylesheet" href="$theme">
				<link rel="stylesheet" href="$main">
				<link rel="stylesheet" href="$navbar">
				<link rel="stylesheet" href="$remixicon">
			</head>
		EOT;

		// Import navbar
		require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_navbar.php");
	}
