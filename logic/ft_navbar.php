<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_nameFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateTheme.php");

	$navbarItem = "";
?>

<body>
<nav class="navbar">
	<?php

	// Icon
	$navbarItem .= '<li><a tabindex="-1" href="/" class="bold no-hover-color"><img class="icon" src="/public/img/logo.ico"></img>' . lang("NAVBAR_TITLE") . '</a></li>';
	$navbarItem .= '<li><a href="/"><i class="ri-home-line"></i>' . lang("NAVBAR_HOME") . '</a></li>';

	// If the user is not connected
	if (!isset($_SESSION["login"])) {
		$navbarItem .= '<li><a href="/login"><i class="ri-user-line"></i>' . lang("NAVBAR_CONNECT") . '</a></li></nav>';

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
		if (in_array(TEACHER, $roleList)) {
			$navbarItem .= '<li><a href="/classes"><i class="ri-folder-line"></i> ' . lang("NAVBAR_CLASS") . '</a></li>';
			$navbarItem .= '<li><a href="/sessioncreation"><i class="ri-computer-line"></i> ' . lang("NAVBAR_CREATE_SESSION") . '</a></li>';
		}

		// Global pages
		if (in_array(ADMIN, $roleList) || in_array(STUDENT, $roleList) || in_array(TEACHER, $roleList)) {
			$navbarItem .= '<li><a href="/sessions"><i class="ri-slideshow-3-line"></i> ' . lang("NAVBAR_SESSION") . '</a></li>';
		}

		// Admin pages
		if (in_array(ADMIN, $roleList)) {
			$navbarItem .= '<li><a href="/utilisateurs"><i class="ri-folder-line"></i> ' . lang("NAVBAR_USER") . '</a></li>';
			$navbarItem .= '<li><a href="/logs?trace"><i class="ri-computer-line"></i> ' . lang("NAVBAR_LOG") . '</a></li>';
		}

		// Profil pages
		$navbarItem .= '<li><div class="profil"><a class="not-profil"><i class="ri-user-line"></i>' . nameFormat($_SESSION["login"], true) . '</a>';
		$navbarItem .= '<ul><div class="sub"><li><a href="/compte"><i class="ri-account-circle-line"></i>' . lang("NAVBAR_PROFIL_ACCOUNT") . '</a></li>';
		$navbarItem .= '<li><a href="/deconnexion"><i class="ri-logout-box-line"></i>' . lang("NAVBAR_PROFIL_DISCONNECT") . '</a></li></div></ul></div></li>';

		// Theme
		$navbarItem .= '<li><form method="POST"><input type="hidden" name="lang" value="' . $userSetting["lang"] . '">';
		$navbarItem .= '<button class="buttonTheme" type="submit" name="theme" value="' . $theme . '">' . $icon . '</button></form></li>';
	}
	echo $navbarItem;
	?>
</nav>

<!-- Background -->
<style>
	body {
		<?php
		// Check if user is connected to change his theme
		if (isset($_SESSION["login"])) {
			$userSetting = UserRepository::getSetting($_SESSION["login"]);

			if ($userSetting["theme"] == "0")
				$theme = "light";
			else
				$theme = "dark";

			echo 'background-image: url("/public/img/background/' . $theme .'/default.png")';
		} else {
			echo 'background-image: url("/public/img/background/light/default.png")';
		}
		?>
	}
</style>
