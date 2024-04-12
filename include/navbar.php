<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/function/ft_nameFormat.php");

	$navbarItem = "";
?>

<body>
<nav class="navbar">
	<?php

	// Icon
	$navbarItem .= '
	<li><a tabindex="-1" href="/" class="bold no-hover-color">
		<div class="iconGlobal">
			<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
				<path class="iconRed" fill="none" stroke="#EA5455" stroke-linecap="round" stroke-miterlimit="10" d="M17.54,10c0,4.16-3.37,7.54-7.54,7.54S2.46,14.16,2.46,10S5.84,2.46,10,2.46c0.9,0,1.77,0.16,2.57,0.45c1.57,0.57,2.89,1.64,3.78,3.02"/>
				<circle class="iconEye" fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="10" cy="10" r="1.61"/>
				<circle class="iconEye" fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" cx="10.81313" cy="10.441631" r="0.21434239" style="stroke-width:0.84206"/>
				<path class="iconYellow" fill="none" stroke="#F4EB6D" stroke-linecap="round" stroke-miterlimit="10" d="M10,15.87c-3.24,0-5.87-2.63-5.87-5.87S6.76,4.13,10,4.13s5.87,2.63,5.87,5.87c0,0.7-0.12,1.38-0.35,2c-0.44,1.22-1.28,2.25-2.35,2.94"/>
				<path class="iconGreen" fill="none" stroke="#8FC263" stroke-linecap="round" stroke-miterlimit="10" d="M7.73,6.63c1.86-1.25,4.38-0.76,5.64,1.1s0.76,4.38-1.1,5.64s-4.38,0.76-5.64-1.1c-0.27-0.4-0.46-0.84-0.57-1.28c-0.22-0.87-0.14-1.79,0.21-2.6"/>
		 	</svg>
			<div class="iconText">'
				 . lang("NAVBAR_TITLE") .
			'</div>
		</div>
	</a></li>';

	// If the user is not connected
	if (!isset($_SESSION["login"])) {
		$navbarItem .= '<li class="item"><a href="/login"><i class="ri-user-line"></i>' . lang("NAVBAR_CONNECT") . '</a></li></nav>';

	// If the user is connected
	} else {
		$roleList = permissionChecker(true, "");

		// Get current user theme
		$userSetting = UserRepository::getSetting($_SESSION["login"]);
		if ($userSetting["theme"] == "0"){
			$theme = "dark";
			$icon = "<i class='ri-moon-line'></i>";
		}
		else {
			$theme = "light";
			$icon = "<i class='ri-sun-line'></i>";
		}

		// Teacher pages
		$navbarItem .= '<li class="item"><a href="/"><i class="ri-home-line"></i>' . lang("NAVBAR_HOME") . '</a></li>';

		if (in_array(TEACHER, $roleList)) {
			$navbarItem .= '<li class="item"><a href="/classes"><i class="ri-folder-line"></i> ' . lang("NAVBAR_CLASS") . '</a></li>';
			$navbarItem .= '<li class="item"><a href="/sessioncreation"><i class="ri-computer-line"></i> ' . lang("NAVBAR_CREATE_SESSION") . '</a></li>';
		}

		// Global pages
		if (in_array(ADMIN, $roleList) || in_array(STUDENT, $roleList) || in_array(TEACHER, $roleList)) {
			$navbarItem .= '<li class="item"><a href="/sessions"><i class="ri-slideshow-3-line"></i> ' . lang("NAVBAR_SESSION") . '</a></li>';
		}

		// Admin pages
		if (in_array(ADMIN, $roleList)) {
			$navbarItem .= '<li class="item"><a href="/utilisateurs"><i class="ri-folder-line"></i> ' . lang("NAVBAR_USER") . '</a></li>';
			$navbarItem .= '<li class="item"><a href="/logs?trace"><i class="ri-computer-line"></i> ' . lang("NAVBAR_LOG") . '</a></li>';
		}

		// Profil pages
		$navbarItem .= '<li class="item"><div class="profil"><a class="not-profil"><i class="ri-user-line"></i>' . nameFormat($_SESSION["login"], true) . '</a>';
		$navbarItem .= '<ul><div class="sub"><li><a href="/compte"><i class="ri-account-circle-line"></i>' . lang("NAVBAR_PROFIL_ACCOUNT") . '</a></li>';
		$navbarItem .= '<li><a href="/deconnexion"><i class="ri-logout-box-line"></i>' . lang("NAVBAR_PROFIL_DISCONNECT") . '</a></li></div></ul></div></li>';

		// Theme
		$navbarItem .= '<li class="item"><button class="buttonTheme" id="themeButton" type="button" name="theme" value="' . $theme . '">' . $icon . '</button></li>';
	}
	echo $navbarItem;
	?>
</nav>

<?php
	if (isset($_SESSION["login"]))
		echo "<script src='/public/js/ft_updateTheme.js'></script>";
?>
