<?php

function mainHeader($title) {
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
		$theme = DEFAULT_THEME;

	$header = "";

	// Create header
	$header .= '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8">';
	$header .= '<title>' . $title . '</title>';

	$header .= '<link rel="stylesheet" href="/public/css/' . $theme . '.css">';
	$header .= '<link rel="stylesheet" href="/public/css/main.css">';
	$header .= '<link rel="stylesheet" href="/public/css/navbar.css">';
	$header .= '<link rel="stylesheet" href="/public/css/import/remixicon.css">';

	$header .= '</head>';

	echo $header;

	// Import navbar
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_navbar.php");
}
