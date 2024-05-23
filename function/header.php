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
			$theme = UserRepository::getSetting($_SESSION["login"])["theme"];
		else
			$theme = DEFAULT_THEME;

		$header = "";

		// Create header
		$header .= '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8">';
		$header .= '<title>' . $title . '</title>';

		$header .= '<link id="headerTheme" rel="stylesheet" href="/public/css/theme/' . $theme . '.css">';
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

		echo "<div class='loading' id='loading' tabindex='-1'>
				<svg class='icon' viewBox='0 0 20 20'>
					<path class='iconRed' fill='none' stroke='#EA5455' stroke-linecap='round' stroke-miterlimit='10' d='M17.54,10c0,4.16-3.37,7.54-7.54,7.54S2.46,14.16,2.46,10S5.84,2.46,10,2.46c0.9,0,1.77,0.16,2.57,0.45c1.57,0.57,2.89,1.64,3.78,3.02'/>
					<circle class='iconEye' fill='none' stroke='#000000' stroke-linecap='round' stroke-miterlimit='10' cx='10' cy='10' r='1.61'/>
					<circle class='iconEye pupil' fill='#000000' stroke='#000000' stroke-linecap='round' stroke-miterlimit='10' cx='10.81313' cy='10.441631' r='0.21434239' style='stroke-width:0.84206'/>
					<path class='iconYellow' fill='none' stroke='#F4EB6D' stroke-linecap='round' stroke-miterlimit='10' d='M10,15.87c-3.24,0-5.87-2.63-5.87-5.87S6.76,4.13,10,4.13s5.87,2.63,5.87,5.87c0,0.7-0.12,1.38-0.35,2c-0.44,1.22-1.28,2.25-2.35,2.94'/>
					<path class='iconGreen' fill='none' stroke='#8FC263' stroke-linecap='round' stroke-miterlimit='10' d='M7.73,6.63c1.86-1.25,4.38-0.76,5.64,1.1s0.76,4.38-1.1,5.64s-4.38,0.76-5.64-1.1c-0.27-0.4-0.46-0.84-0.57-1.28c-0.22-0.87-0.14-1.79,0.21-2.6'/>
				</svg>
				<h2>" . lang("MAIN_LOADING") . "</h2>
			</div>";
		echo '<div id="main">';

		echo "<noscript><div class='noScript'>Please enable JavaScript on this website.</div></noscript>";
	}
}
