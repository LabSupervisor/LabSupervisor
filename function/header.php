<?php

namespace LabSupervisor\functions;
use LabSupervisor\app\repository\UserRepository;

if (!function_exists(__NAMESPACE__ . "/mainHeader")) {
	function mainHeader($title, $navbar) {
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

		$header .= '<link id="headerTheme" rel="stylesheet" href="/public/css/' . $theme . '.css">';
		$header .= '<link rel="stylesheet" href="/public/css/main.css">';
		$header .= '<link rel="stylesheet" href="/public/css/navbar.css">';
		$header .= '<link rel="stylesheet" href="/public/css/import/remixicon.css">';
		$header .= '<link rel="stylesheet" href="/public/css/footer.css">';

		$header .= '</head>';

		echo $header;

		if (isset($_SESSION["login"]))
			echo
				"<script>" .
					"var userId = ". $_SESSION["login"] . ";" .
					"var userLang = '". UserRepository::getSetting($_SESSION["login"])["lang"] . "';" .
					"var defaultLang = '". DEFAULT_LANGUAGE . "';" .
				"</script>";

		if ($navbar) {
			// Import navbar
			require($_SERVER["DOCUMENT_ROOT"] . "/include/navbar.php");
		}

		echo '<div id="main">';
	}
}
