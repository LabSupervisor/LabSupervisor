<?php

	use LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\lang,
		LabSupervisor\functions\nameFormat;

?>

<body>

<?php
	$navbarItem = "";

	// Icon
	$navbarItem .= '
		<div class="navbarGroup">
			<div class="item">
				<div class="iconGroup">
					<a class="title" tabindex="-1" href="/">
						<svg class="icon" viewBox="0 0 20 20">
							<path class="iconRed" fill="none" stroke="#EA5455" stroke-linecap="round" stroke-miterlimit="10" d="M17.54,10c0,4.16-3.37,7.54-7.54,7.54S2.46,14.16,2.46,10S5.84,2.46,10,2.46c0.9,0,1.77,0.16,2.57,0.45c1.57,0.57,2.89,1.64,3.78,3.02"/>
							<circle class="iconEye" fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="10" cy="10" r="1.61"/>
							<circle class="iconEye pupil" fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="10.81313" cy="10.441631" r="0.21434239" style="stroke-width:0.84206"/>
							<path class="iconYellow" fill="none" stroke="#F4EB6D" stroke-linecap="round" stroke-miterlimit="10" d="M10,15.87c-3.24,0-5.87-2.63-5.87-5.87S6.76,4.13,10,4.13s5.87,2.63,5.87,5.87c0,0.7-0.12,1.38-0.35,2c-0.44,1.22-1.28,2.25-2.35,2.94"/>
							<path class="iconGreen" fill="none" stroke="#8FC263" stroke-linecap="round" stroke-miterlimit="10" d="M7.73,6.63c1.86-1.25,4.38-0.76,5.64,1.1s0.76,4.38-1.1,5.64s-4.38,0.76-5.64-1.1c-0.27-0.4-0.46-0.84-0.57-1.28c-0.22-0.87-0.14-1.79,0.21-2.6"/>
						</svg>
						<span id="navbarTitle">' . lang("NAVBAR_TITLE") . '</span>
					</a>
				</div>
			</div>';

	// If the user is not connected
	if (!isset($_SESSION["login"])) {
		$navbarItem .= '
			<div class="item">
				<a href="/login"><i class="ri-user-line"></i>' . lang("NAVBAR_CONNECT") . '</a>
			</div>
		</div>';

	// If the user is connected
	} else {
		// Get navbar elements
		$item = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/config/route.json"));

		// Only me now how this work. Don't ask me.
		foreach ($item as $value) {
			if (isset($value->navbar) && array_intersect($value->role, UserRepository::getRole($_SESSION["login"]))) {
				$selected = "";
				$subRoutes = array();

				if (isset($value->navbar->sub)) {
					foreach ($value->navbar->sub as $subValue) {
						$subRoutes = array_merge($subRoutes, $item->{$subValue}->route);
					}
				}

				if (in_array(explode("?", $_SERVER["REQUEST_URI"])[0], array_merge($value->route, $subRoutes))) {
					$selected = "<div class='current'></div>";
				}

				$navbarItem .= '
				<div class="item">
					<a href="' . $value->route[0] . '"><i class="' . $value->navbar->icon . '"></i>' . lang($value->navbar->title) . '</a>' .
				$selected .
				'</div>';
			}
		}

		// Profil pages
		$navbarItem .= '
			<div class="item profil">
				<a class="title"><i class="ri-user-line"></i>' . nameFormat($_SESSION["login"], true) . '</a>
				<div class="sub">
					<div class="item">
						<a href="/compte"><i class="ri-account-circle-line"></i>' . lang("NAVBAR_PROFIL_ACCOUNT") . '</a>
					</div>
					<div class="item">
						<a href="/deconnexion"><i class="ri-logout-box-line"></i>' . lang("NAVBAR_PROFIL_DISCONNECT") . '</a>
					</div>
				</div>
			</div>';

		// Theme

		// Get current user theme
		$theme = "light";
		$icon = "<i class='ri-sun-line'></i>";

		if (UserRepository::getSetting($_SESSION["login"])["theme"] == "0") {
			$theme = "dark";
			$icon = "<i class='ri-moon-line'></i>";
		}

		$navbarItem .= '
			<div class="item">
				<button class="theme" id="themeButton" type="button" name="theme" value="' . $theme . '">' . $icon . '</button>
			</div>
		</div>';
	}

	echo $navbarItem;
?>

<?php
	echo "<script src='/public/js/ft_lang.js'></script>";
	if (isset($_SESSION["login"]))
		echo "<script src='/public/js/ft_updateTheme.js'></script>";
?>
