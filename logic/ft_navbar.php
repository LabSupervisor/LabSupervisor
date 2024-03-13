<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_nameFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateTheme.php");
?>

<body>
	<nav class="navbar">
		<li>
			<a tabindex="-1" href="/" class="bold no-hover-color"><img class="icon" src='/public/img/logo.ico'></img><?= lang("NAVBAR_TITLE") ?></a>
		</li>
		<li>
			<a href="/"><i class="ri-home-line"></i> <?= lang("NAVBAR_HOME") ?></a>
		</li>
		<?php
		// Check if user is connected
		if (!isset($_SESSION["login"])) { ?>
		<li>
			<a href="/login"><i class="ri-user-line"></i> <?= lang("NAVBAR_CONNECT") ?></a>
		</li>
	</nav>
		<?php
		// If the user is connected
		} else {
			$navbarItem = "";
			$roleList = permissionChecker(true, "");
			$userSetting = UserRepository::getSetting($_SESSION["login"]);

			if (in_array(TEACHER, $roleList)) {
				$navbarItem .= '<li><a href="/classes"><i class="ri-folder-line"></i> ' . lang("NAVBAR_CLASS") . '</a></li>';
				$navbarItem .= '<li><a href="/sessioncreation"><i class="ri-computer-line"></i> ' . lang("NAVBAR_CREATE_SESSION") . '</a></li>';
			}

			if (in_array(ADMIN, $roleList) || in_array(STUDENT, $roleList) || in_array(TEACHER, $roleList)) {
				$navbarItem .= '<li><a href="/sessions"><i class="ri-slideshow-3-line"></i> ' . lang("NAVBAR_SESSION") . '</a></li>';
			}

			if (in_array(ADMIN, $roleList)) {
				$navbarItem .= '<li><a href="/utilisateurs"><i class="ri-folder-line"></i> ' . lang("NAVBAR_USER") . '</a></li>';
				$navbarItem .= '<li><a href="/logs?trace"><i class="ri-computer-line"></i> ' . lang("NAVBAR_LOG") . '</a></li>';
			}

			echo $navbarItem;

		?>
		<li>
			<div class="profil">
			<a class="not-profil"><i class="ri-user-line"></i> <?= nameFormat($_SESSION["login"], true) ?></a>
			<ul>
				<div class="sub">
				<li>
					<a href="/compte"><i class="ri-account-circle-line"></i> <?= lang("NAVBAR_PROFIL_ACCOUNT") ?></a>
				</li>
				<li>
					<a href="/deconnexion"><i class="ri-logout-box-line"></i> <?= lang("NAVBAR_PROFIL_DISCONNECT") ?></a>
				</li>
				</div>
			</ul>
		</li>
		<li>
			<form method="POST">
				<?php
				if ($userSetting["theme"] == "0"){
					$theme = "dark";
					$icon = "<i class='ri-moon-line'></i>";
				}
				else {
					$theme = "light";
					$icon = "<i class='ri-sun-line'></i>";
				}
				?>
				<input type="hidden" name="lang" value="<?= $userSetting["lang"] ?>">
				<button class="buttonTheme" type="submit" name="theme" value="<?= $theme ?>"><?= $icon ?></button>
			</form>
		</li>
		</div>
	</nav>
	<?php
		}
	?>

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
				?>
				background-image: url("/public/img/background/<?=$theme?>/default.png");
			<?php
			} else { ?>
				background-image: url("/public/img/background/light/default.png");
			<?php
			} ?>
		}
	</style>

	<div class="main">
